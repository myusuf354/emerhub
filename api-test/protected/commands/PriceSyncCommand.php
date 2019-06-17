<?php
date_default_timezone_set('Asia/Jakarta');
//MyApp::sendEmail('testing', 'muhmdysf@gmail.com', 'konten', 'Testing', 'tetsing', 123);
class PriceSyncCommand extends CConsoleCommand{
	public function run($args){
		$type	=	array(
			'data' => 1,
			'reguler' => 1,
			'games' => 2,
			'gojek' => 3
		);
		foreach($type as $keytp => $tp){
			$category_id = 0;
			if($keytp == 'data'){
				$category_id = 1;
			}elseif($keytp == 'reguler'){
				$category_id = 2;
			}elseif($keytp == 'games'){
				$category_id = 4;
			}elseif($keytp == 'gojek'){
				$category_id = 5;
			}
			$product_reguler	=	PayRfProductProvider::model()->findAllByAttributes(array('check_price'=>$tp));
			foreach($product_reguler as $key => $provider){
				$get_price		=	PintechRest::CheckPrice($keytp,$provider->provider_name);
				$data_return	= 	explode(";",$get_price);
				//var_dump($data_return); exit;
				$x=0;
				foreach($data_return as $data){
					if($x >= 2){
						if($data != '*' AND $data != ''){
							$exp_data	= 	explode(" ",$data);
							// [0] : kode produk
							// [1] : =
							// [2] : harga
							// [3] : status
							// [4] : |
							// [5]+ : deskripsi
							$update = false;
							if($provider->provider_name == 'BIZNET'){
								$category_id = 1;
							}
							$check_product = PayRfProduct::model()->findByAttributes(array('product_code'=>$exp_data[0],'product_category_id'=>$category_id));
							if($check_product == null){
								$check_product = new PayRfProduct;
								$check_product->provider_id			= 1;
								$check_product->product_provider_id	= $provider->id;
								$check_product->product_category_id	= $category_id;
								$check_product->product_code		= $exp_data[0];
								$check_product->product_name		= $provider->provider_name;
								$exp_desc	= 	explode(" | ",$data);
								$check_product->product_description	= $exp_desc[1];
								$update = true;
							}else{
								if($check_product->price_provider != $exp_data[2]){
									$add_log = $exp_data[0].'|'.$check_product->price_provider.'|'.$check_product->price_ubequ.'|'.$check_product->last_update;
									$check_product->update_log	= $check_product->update_log.';'.$add_log;
									$update = true;
								}
							}
							
							$check_product->price_provider	= $exp_data[2];
							$ubequ_price = PayUbequPrice::model()->findByAttributes(array('status'=>1,'product'=>$keytp));
							$upprice = 0;
							if($ubequ_price!=null){
								if($ubequ_price->type=='Rp'){
									$upprice = $ubequ_price->value;
								}elseif($ubequ_price->type=='%'){
									$upprice = $exp_data[2] * $ubequ_price->value / 100;
								}
							}
							$check_product->price_ubequ		= $exp_data[2] + $upprice;
							$check_product->admin_fee		= 0;
							$check_product->last_update		= date('Y-m-d H:i:s');
							$check_product->created_by		= 'cron system';
							$status = '';
							if($exp_data[3] == '[Ready]'){
								$status = 'tersedia';
							}elseif($exp_data[3] == '[Close]'){
								$status = 'gangguan';
							}
							$check_product->status				= $status;
							
							$check_product->save();
						}
					}
					$x++;
				}
			}
		}
	}
}
?>