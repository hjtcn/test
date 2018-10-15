<?php

//抓取cm 3d主题信息

_main();


//此脚本调用的主函数
function _main()
{
	$arr = array();
	$data1 = getData(1);
	$data2 = getData(2);
	$data3 = getData(3);
	$data = array_merge($data1,$data2,$data3);
	foreach($data as $k=>$v){
		$tmp = array();
		$tmp['name'] = $v['name'];
		$tmp['packageName'] = $v['packageName'];
		$tmp['newcover_url'] = $v['newcover_url'];
		$tmp['ctime'] = $v['ctime'];
		$tmp['favorite_count'] = $v['favorite_count'];
		$tmp['download_url'] = $v['download_url'];
		$tmp['download_count'] = $v['download_count'];
		$tmp['cml_install'] = $v['cml_install'];
		$tmp['dl_count'] = $v['dl_count'];
		$tmp['is_recommand'] = $v['is_recommand'];
		$arr[] = $tmp;
	}
	/**
	foreach($arr as $v){
		writeFile($v);
	}**/
	writeExcel($arr);
}

//将数据写入懂啊Excel表格中
function writeExcel($data)
{
	$rs = fopen('./cm3d.xlsx', 'w');
	$field = '';
	foreach($data as $val){
		foreach($val as $k=>$v){
			$field = $field . $k . "\t";
		}
		break;
	}
	$field = $field . "\n";
	$field = "name\tpackageName\tnewcover_url\tctime\tfavorite_count\tdownload_url\tdownload_count\tcml_install\tdl_count\tis_recommand\t\n";
	//var_dump($field);exit;
	fwrite($rs, $field);
	foreach($data as $v){
		fwrite($rs, $v['name']."\t".$v['packageName']."\t".$v['newcover_url']."\t".$v['ctime']."\t".$v['favorite_count']."\t".$v['download_url']."\t".$v['download_count']."\t".$v['cml_install']."\t".$v['dl_count']."\t".$v['is_recommand']."\t\n");
	}
	fclose($rs);
}

//调用接口，获取cm 3d主题数据
function getData($p=1)
{
	$ch = curl_init('http://cml.ksmobile.com/Album/getThemeList?p=' . $p . '&album_id=67&p_n=150&pos=110&appv=5.48.2');
	curl_setopt($ch, CURLOPT_POST, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$data = curl_exec($ch);
	curl_close($ch);
	$data = json_decode($data, true);
	return $data['data'];
}

//将获取的字符串写入到文件中
function writeFile($data)
{
	$rs = fopen('./cm3d.txt','a');
	foreach($data as $k=>$v){
		fwrite($rs, $k.': ' . $v . "\n");
	}
	fwrite($rs, "\n");
	fclose($rs);
}
