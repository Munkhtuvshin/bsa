$table->increments('id');
            $table->integer('organization_id')->unsigned()->index();
            $table->integer('merchant_id')->unsigned()->index();
            $table->string('coupon_id', 30);
            $table->boolean('is_simple')->default(true) //true ? 'it is only create coupon' : 'it belongs to QR code and promo code'
            $table->boolean('has_middle_image')->default(true) //true ? 'it is only create coupon' : 'it belongs to QR code and promo code'
            $table->boolean('has_value')->default(true) //true ? There will be value seen in header right 
            $table->boolean('has_footer')->default(true) // if has footer there will be long description will be seen
            $table->string('title', 300);
            $table->string('short_description', 300);
            $table->string('long_description');
            $table->string('value', 100);
            $table->string('cover_url');
            $table->string('middle_image_url');
            $table->bigInteger('quantity');
            $table->date('expired_at')->default(null);