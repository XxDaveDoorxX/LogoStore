<?php

namespace LogoStore\Http\Controllers\Admin;

use LogoStore\Http\Controllers\Controller;
use Illuminate\Http\Request;

use LogoStore\Http\Requests;
use LogoStore\Http\Requests\CreateOrderRequest;
use LogoStore\Order;

class OrderController extends Controller
{
    use RedirectWithSessionMessage;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with(['logo', 'customer'])->orderBy('created_at', 'DESC')->paginate();
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::with('logo', 'customer')->findOrFail($id);

        return view('admin.orders.details', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateOrderRequest $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->fill($request->all());

        $order->save();

        return $this->redirectWithFlashMessage(
            'Esta orden fue modificado exitosamente.',
            $request->ajax(),
            redirect()->route('admin.orders.index')
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,  Request $request)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return $this->redirectWithFlashMessage(
            'La orden "' .$order->id. '" fue eliminado de nuestros registros.',
            $request->ajax(),
            redirect()->route('admin.orders.index')
        );
    }
}
