<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSurprisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_surprises', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->integer('sender_id');
            $table->integer('receiver_id');
            $table->string('text')->nullable()->default(null);;
            $table->enum('file_type', ['image', 'video'])->nullable()->default(null);
            $table->string('attachment_file_id')->nullable()->default(null);
            $table->string('reaction_file_id')->nullable()->default(null);
            $table->boolean('is_rejected')->default(false);
            $table->timestamp('reaction_date')->nullable()->default(null);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('model_surprise');
    }
}
