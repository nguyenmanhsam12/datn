<?php

namespace App\Components;

class Permission{

    private $data;
    // biến này lưu trữ mã html option trong quá trình đệ quy tạo ra
    private $htmlSelect = '';

    public function __construct($data){
        $this->data = $data;
    }   

    public function permissionRecusive($parentId , $id = 0 , $text = ''){
        foreach($this->data as $value){
            if($value['parent_id'] == $id){
                // parentId không rỗng và bằng với id
                if(!empty($parentId) && $parentId == $value['id']){
                    $this->htmlSelect .= "<option selected value = '".$value['id']."'>".$text.$value['name']."</option>";
                }else{
                    $this->htmlSelect .= "<option  value = '".$value['id']."'>".$text.$value['name']."</option>";
                }
                $this->permissionRecusive($parentId,$value['id'],$text.'--');
            }
        }   
        return $this->htmlSelect;
    }
}

?>