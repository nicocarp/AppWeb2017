<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturaDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factura_detalles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('factura_id')->unsigned();
            $table->foreign('factura_id')->references('id')
                                         ->on('facturas')  
                                         ->onDelete('cascade');
            $table->integer('producto_id')->unsigned();
            $table->foreign('producto_id')->references('id')
                                         ->on('productos')  
                                         ->onDelete('cascade');
            $table->integer('cantidad');
            $table->decimal('precio',10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('factura_detalles');
    }
}
