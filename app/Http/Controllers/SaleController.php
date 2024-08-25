<?php

namespace App\Http\Controllers;

use App\Events\SaleCreate;
use App\Models\Sale;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use App\Models\Product;
use App\Models\SaleProduct;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->can('viewAny', Sale::class)) {
            toastr()->error('Você não tem permissão para acessar essa página');
            return redirect()->back();
        }

        $user = auth()->user();
        $search = request()->input('search');

        // Filtra as vendas com base no papel do usuário
        $query = Sale::query();

        if ($user->role === 'seller') {
            $query->where('seller_id', $user->id);
        } elseif ($user->role === 'customer') {
            $query->where('customer_id', $user->id);
        }

        if ($search) {
            // Pesquisa por data, cliente, produto ou categoria de produto
            $query->where(function ($query) use ($search) {
                $query->where('created_at', 'like', '%' . $search . '%')
                    ->orWhereHas('customer', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('seller', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('products', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%')
                            ->orWhereHas('category', function ($query) use ($search) {
                                $query->where('name', 'like', '%' . $search . '%');
                            });
                    });
            });
        }

        $sales = $query->orderBy('created_at', 'desc')->paginate(10)->appends(['search' => $search]);

        return view('sales.index', compact('sales'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sellers = User::where('role', 'seller')->get();
        $customers = User::where('role', 'customer')->get();
        $products = Product::all();

        $cart = session('cart', []);

        //parsing cart->product_id to product
        $cart_products = array_map(function ($item) use ($products) {
            $product = $products->firstWhere('id', $item['product_id']);
            $item['product'] = $product;
            return $item;
        }, $cart);

        //Calculando o total a partir do valor atual dos produtos no banco
        $total = array_reduce($cart_products, function ($carry, $item) {
            return $carry + (float) $item['product']->unformatted_price * $item['quantity'];
        }, 0);

        return view('sales.create', compact('sellers', 'customers', 'products', 'cart_products', 'total'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSaleRequest $request)
    {
        $cart = session('cart', []);

        if (count($cart) === 0) {
            toastr()->error('Carrinho vazio');
            return back();
        }

        try {
            DB::beginTransaction();

            $sale = Sale::create([
                'seller_id' => $request->seller,
                'customer_id' => $request->customer,
                'total_amount' => 0,
                'total_quantity' => 0,
            ]);

            foreach ($cart as $item) {
                SaleProduct::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['product']->unformatted_price,
                ]);
            }

            DB::commit();
            session()->forget('cart');

            event(new SaleCreate($sale));

            toastr()->success('Venda realizada com sucesso');
            return redirect()->route('sales.index');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            toastr()->error('Erro ao realizar a venda');
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        if (!auth()->user()->can('view', $sale)) {
            toastr()->error('Você não tem permissão para visualizar vendas');
            return redirect()->route('index');
        }

        return view('sales.show', compact('sale'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        if (!auth()->user()->can('delete', $sale)) {
            toastr()->error('Você não tem permissão para deletar vendas');
            return redirect()->route('index');
        }

        $sale->delete();

        toastr()->success('Venda deletada com sucesso');
        return redirect()->route('sales.index');
    }

    public function removeItem(SaleProduct $saleProduct)
    {
        if (!auth()->user()->can('delete', $saleProduct->sale)) {
            toastr()->error('Você não tem permissão para deletar itens da venda');
            return redirect()->route('index');
        }

        $saleProduct->delete();

        toastr()->success('Item removido da venda');
        return back();
    }

    public function updateItem(SaleProduct $saleProduct)
    {
        if (!auth()->user()->can('update', $saleProduct->sale)) {
            toastr()->error('Você não tem permissão para atualizar itens da venda');
            return redirect()->route('index');
        }

        $saleProduct->quantity = request()->quantity;
        $saleProduct->save();

        toastr()->success('Quantidade atualizada');
        return back();
    }

    public function generatePDF()
    {
        // Obtém os dados das vendas
        $sales = Sale::with('customer', 'seller')->get(); // Adapte a consulta conforme necessário

        // Gera o PDF a partir da view e passa os dados para a view
        $pdf = Pdf::loadView('pdf.sales', compact('sales'));

        // Retorna o PDF renderizado para o navegador
        return $pdf->stream('vendas.pdf');
    }
}
