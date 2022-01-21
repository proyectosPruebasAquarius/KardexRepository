<?php

namespace App\Http\Livewire;

use App\DetalleInventariosModel;
use App\Documento;
use App\Notifications\ProductStock;
use App\Pedido;
use App\TipoDocumento;
use App\User;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Notification;

class DetalleInventarios extends Component
{
    use LivewireAlert;
    public $id_inventario;
    public $concepto;
    public $cantidad;
    public $tipo_documento;
    public $precio_unitario;
    public $fecha_registro;
    public $origen;
    public $factura;
    public $factura_proveedor;
    public $id_factura;
    public $tipos = [];
    public $documentos = [];

    protected $listeners = ['resetNamesDetalleInventarios' => 'resetInput', 'asignDetalleInventario' => 'asignDetalleInventario'];

    protected $rules = [

        'concepto' => 'required|min:5|max:150',
        'fecha_registro' => 'required|date',
        'cantidad' => 'required|numeric|min:1',

    ];

    protected $messages = [
        'concepto.required' => 'El Concepto es Obligatorio',
        'concepto.min' => 'Debe contener al menos :min caracteres',
        'concepto.max' => 'Debe contener un maximo :max caracteres',
        'precio_unitario.required' => 'El Precio Unitario es Obligarorio',
        'precio_unitario.regex' => 'Formato No Valido',
        'fecha_registro.required' => 'La Fecha es Obligatoria',
        'fecha_registro.date' => 'Formato no Valido',
        'cantidad.required' => 'La cantidad es Obligatoria',
        'cantidad.min' => 'La cantidad debe ser igual o mayor a :min',
        'tipo_documento.required' => 'El tipo de documento es Obligatorio',
        'factura.required' => 'El numero de factura es Obligatorio',
        'factura_proveedor.required' => 'El numero de factura del Proveedor es Obligatorio',
        'id_factura.required' => 'La Factura de compra es Obligatoria',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function asignDetalleInventario($inventario)
    {
        $this->id_inventario = $inventario['id_inventario'];

    }
    public function resetInput()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset(['id_inventario', 'concepto', 'precio_unitario', 'cantidad', 'factura', 'factura_proveedor', 'fecha_registro', 'origen', 'tipo_documento']);
    }

    public function createDetalleInventario()
    {
        switch ($this->origen) {
            case 'Entrada':
                $this->rules = [
                    'concepto' => 'required|min:5|max:150',
                    'precio_unitario' => ['required', 'regex:/^(?:[1-9]\d+|\d)(?:\.\d\d)?$/'],
                    'fecha_registro' => 'required|date',
                    'cantidad' => 'required|numeric|min:1',
                    'tipo_documento' => 'required',
                    'factura' => 'required',
                    'factura_proveedor' => 'required',
                ];
                break;

            case 'Salida':
                $this->rules = [
                    'concepto' => 'required|min:5|max:150',
                    'fecha_registro' => 'required|date',
                    'cantidad' => 'required|numeric|min:1',
                    'tipo_documento' => 'required',
                    'factura' => 'required',
                ];
                break;
            case 'DevCompra':
                $this->rules = [
                    'concepto' => 'required|min:5|max:150',
                    'fecha_registro' => 'required|date',
                    'cantidad' => 'required|numeric|min:1',
                    'precio_unitario' => ['required', 'regex:/^(?:[1-9]\d+|\d)(?:\.\d\d)?$/'],
                ];
                break;
            case 'DevVenta':
                $this->rules = [
                    'concepto' => 'required|min:5|max:150',
                    'fecha_registro' => 'required|date',
                    'cantidad' => 'required|numeric|min:1',
                    'id_factura' => 'required',
                ];
                break;
        }
        $this->validate();
        try {
            DB::beginTransaction();

            $saveDetalle = new DetalleInventariosModel;
            $lastInsert = DetalleInventariosModel::select('cantidad_saldo', 'total_saldo')->orderBy('id', 'DESC')->get();
            $promedioPonderado = DetalleInventariosModel::whereNotNull('cantidad_entrada')->select('cantidad_entrada', 'precio_unitario')->orderBy('id', 'DESC')->first();
            if ($this->origen == 'Entrada' && $this->factura_proveedor == null) {
                $this->dispatchBrowserEvent('closeModal');
                $this->alert('error', 'Has selecionado una Entrada, por lo cual el Documento del Proveedor es Obligatorio', [
                    'position' => 'center',
                    'timer' => 2000,
                ]);
            } else {
                if ($this->origen == 'Entrada' || $this->origen == 'Salida') {
                    $documento = new Documento;
                    $documento->factura = $this->factura;
                    $documento->factura_proveedor = $this->factura_proveedor;
                    $documento->id_tipo_documento = $this->tipo_documento;
                    $documento->save();
                } 
                
               

                $saveDetalle->id_inventario = $this->id_inventario;
                $saveDetalle->concepto = $this->concepto;
                $saveDetalle->fecha_registro = $this->fecha_registro;

                if (sizeof($lastInsert) == 0 && $this->origen == 'Salida') {
                    $this->dispatchBrowserEvent('closeModal');
                    $this->alert('error', 'No Puedes ingresar Salida. Por que este Inventario todavia no tiene ninguna Entrada', [
                        'position' => 'center',
                        'timer' => 5000,
                    ]);
                }
                if ($this->origen == 'Entrada') {
                    if (sizeof($lastInsert) == 0) {
                        $saveDetalle->cantidad_entrada = $this->cantidad;
                        $saveDetalle->total_entrada = round($this->precio_unitario * $this->cantidad, 3);
                        $saveDetalle->total_entrada = bcdiv($saveDetalle->total_entrada,'1',2);

                        $saveDetalle->cantidad_saldo = $this->cantidad;
                        $saveDetalle->total_saldo = round($this->precio_unitario * $this->cantidad, 3);
                        $saveDetalle->total_saldo =  bcdiv($saveDetalle->total_saldo,'1',2);
                        $saveDetalle->id_documento = $documento->id;
                        $saveDetalle->precio_unitario = $this->precio_unitario;
                       
                        $saveDetalle->save();
                        DB::commit();
                    } else {

                        $saveDetalle->cantidad_entrada = $this->cantidad;
                        $saveDetalle->cantidad_saldo = $lastInsert[0]->cantidad_saldo + $this->cantidad;
                        $saveDetalle->id_documento = $documento->id;

                        $total_promedio = $lastInsert[0]->total_saldo + $this->precio_unitario * $this->cantidad;
                        $cantidad_promedio = $lastInsert[0]->cantidad_saldo + $this->cantidad;
                        $saveDetalle->precio_unitario_proveedor = $this->precio_unitario;

                        $saveDetalle->precio_unitario = round($total_promedio / $cantidad_promedio, 3);
                        $saveDetalle->precio_unitario = bcdiv($saveDetalle->precio_unitario,'1',2);

                        $saveDetalle->total_saldo = round($saveDetalle->precio_unitario * $saveDetalle->cantidad_saldo, 3);
                        $saveDetalle->total_saldo = bcdiv($saveDetalle->total_saldo,'1',2);

                        $saveDetalle->total_entrada = round($this->precio_unitario * $this->cantidad, 3);
                        $saveDetalle->total_entrada = bcdiv($saveDetalle->total_entrada,'1',2);
                        $saveDetalle->save();
                        DB::commit();
                    }
                } elseif ($this->origen == 'Salida') {
                    $saveDetalle->cantidad_salida = $this->cantidad;
                    $saveDetalle->cantidad_saldo = $lastInsert[0]->cantidad_saldo - $this->cantidad;
                    $saveDetalle->id_documento = $documento->id;
                    $saveDetalle->precio_unitario = $promedioPonderado->precio_unitario;

                    $saveDetalle->total_salida = round($saveDetalle->precio_unitario * $this->cantidad, 3);
                    $saveDetalle->total_salida = bcdiv($saveDetalle->total_salida,'1',2);

                    $saveDetalle->total_saldo = round($saveDetalle->precio_unitario * $saveDetalle->cantidad_saldo, 3);
                    $saveDetalle->total_saldo = bcdiv($saveDetalle->total_saldo,'1',2);
                    $saveDetalle->save();
                    DB::commit();

                } elseif ($this->origen == 'DevCompra') {

                    $saveDetalle->cantidad_entrada = $this->cantidad;
                    $saveDetalle->total_entrada = round($this->precio_unitario * $this->cantidad, 3);
                    $saveDetalle->total_entrada = bcdiv($saveDetalle->total_entrada,'1',2);


                    $total_promedio = $lastInsert[0]->total_saldo - $this->precio_unitario * $this->cantidad;
                    $cantidad_promedio = $lastInsert[0]->cantidad_saldo - $this->cantidad;
                    $saveDetalle->precio_unitario = round($total_promedio / $cantidad_promedio, 3);
                    $saveDetalle->precio_unitario = bcdiv($saveDetalle->precio_unitario,'1',2);


                    $saveDetalle->origen = 1;
                    $saveDetalle->precio_unitario_proveedor = $this->precio_unitario;
                    $saveDetalle->cantidad_saldo = $lastInsert[0]->cantidad_saldo - $this->cantidad;
                    $saveDetalle->total_saldo = round($saveDetalle->precio_unitario * $saveDetalle->cantidad_saldo,3);
                    $saveDetalle->total_saldo = bcdiv($saveDetalle->total_saldo,'1',2);
                    
                    
                    $saveDetalle->save();
                    DB::commit();
                } elseif ($this->origen == 'DevVenta') {

                    $saveDetalle->cantidad_salida = $this->cantidad;
                    $precio_unitario_last = DetalleInventariosModel::join('documentos', 'documentos.id', '=', 'detalles_inventarios.id_documento')
                        ->select('detalles_inventarios.precio_unitario')->where('detalles_inventarios.id_documento', $this->id_factura)->first();
                    $saveDetalle->total_salida = round($precio_unitario_last->precio_unitario * $this->cantidad, 3);

                    $total_promedio = $lastInsert[0]->total_saldo + $precio_unitario_last->precio_unitario * $this->cantidad;
                    $cantidad_promedio = $lastInsert[0]->cantidad_saldo + $this->cantidad;
                    $saveDetalle->precio_unitario = round($total_promedio / $cantidad_promedio, 3);
                    $saveDetalle->precio_unitario = bcdiv($saveDetalle->precio_unitario,'1',2);
                    $saveDetalle->origen = 2;
                    $saveDetalle->cantidad_saldo = $lastInsert[0]->cantidad_saldo + $this->cantidad;
                    $saveDetalle->total_saldo = round($saveDetalle->precio_unitario * $saveDetalle->cantidad_saldo, 3);
                    $saveDetalle->total_saldo = bcdiv($saveDetalle->total_saldo,'1',2);

                    $saveDetalle->save();
                    DB::commit();
                }
                session(['alert' => ['type' => 'success', 'message' => 'Inventario Guardado con éxito.', 'position' => 'center']]);
                $this->dispatchBrowserEvent('closeModal');
                $users = User::get();

                $cod = DB::table('inventarios')->join('productos', 'inventarios.id_producto', '=', 'productos.id')->where('inventarios.id', $this->id_inventario)->value('productos.cod_producto');
                $stockMin = DB::table('inventarios')->where('id', $this->id_inventario)->value('cantidad_min');
                $id_pForP = DB::table('inventarios')->join('productos', 'inventarios.id_producto', '=', 'productos.id')->where('inventarios.id', $this->id_inventario)->value('productos.id');
                $details = $this->origen == 'Entrada'
                ?
                [
                    'message_title' => 'Ha Ocurrido una Nueva Entrada ' . $cod,
                    'message_body' => 'Se ha relizado un cambio en inventarios, concepto Entrada',
                ]
                :
                [
                    'message_title' => 'Ha Ocurrido una Nueva Salida ' . $cod,
                    'message_body' => 'Se ha relizado un cambio en inventarios, concepto Salida',
                ];

                $pdido = new Pedido;
                $pdido->id_producto = $id_pForP;
                $pdido->save();

                if ($saveDetalle->cantidad_saldo <= $stockMin) {
                    $newDetail = [
                        'message_title' => 'Cantidad minima de inventario igual o menor ' . $cod,
                        'message_body' => [
                            'type' => 'min',
                            'id_pedido' => $pdido->id,
                            'cod' => $cod],
                    ];
                    Notification::send($users, new ProductStock($newDetail));
                }
                Notification::send($users, new ProductStock($details));

                return redirect()->to('/inventarios');
            }

        } catch (\Exception $th) {
            DB::rollBack();
            session(['alert' => ['type' => 'error', 'message' => $th->getMessage(), 'position' => 'center']]);
            $this->dispatchBrowserEvent('closeModal');

            return redirect()->to('/inventarios');
        }

    }

    public function render()
    {

        if (!empty($this->id_inventario)) {
            $this->documentos = Documento::join('detalles_inventarios', 'detalles_inventarios.id_documento', '=', 'documentos.id')->select('documentos.id', 'documentos.factura')
                ->where('detalles_inventarios.id_inventario', $this->id_inventario)->get();
        }

        $this->tipos = TipoDocumento::where('estado', 1)->select('nombre', 'id')->get();
        return view('livewire.detalle-inventarios');
    }
}
