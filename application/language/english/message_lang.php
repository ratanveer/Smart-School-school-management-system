<?php
$CI = & get_instance();
$adm = $CI->session->userdata('admin');
$student = $CI->session->userdata('student');
if ($adm) {
    $language = $adm["language"]['lang_id'];
} else if ($student) {
    $language = $student["language"]['lang_id'];
}else{
	 $setting_result = $CI->setting_model->get();
$language =$setting_result[0]['lang_id'];
	 
}

$CI->db->select('lang_pharses.pharses,languages.language,lang_keys.key')->from('lang_pharses');
$CI->db->join('languages', 'lang_pharses.lang_id = languages.id');
$CI->db->join('lang_keys', 'lang_keys.id = lang_pharses.key_id');
$CI->db->where('lang_pharses.lang_id', $language);

$query = $CI->db->get();

$result = $query->result();

foreach ($result as $language) {
    $lang['' . $language->key . ''] = "" . $language->pharses . "";
}
?>