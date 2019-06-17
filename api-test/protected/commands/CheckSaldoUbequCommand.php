<?php
date_default_timezone_set('Asia/Jakarta');
class CheckSaldoUbequCommand extends CConsoleCommand{
	public function run($args){
		$call_provider 	= PintechRest::SaldoUbequ();
		$data_return	= explode(";",$call_provider);
		$split_return	= explode(".",$data_return[2]);
		
		if($split_return[0]!='E4'){
			$saldo 				= PayUbequSaldo::model()->findByPk(1);
			$saldo->saldo 		= $split_return[0];
			$saldo->last_update = date('Y-m-d H:i:s');
			$saldo->save();
		}
	}
}
?>