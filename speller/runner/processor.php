<?php
    $text = $_POST['text_input'];
    $bt_head = null;
    
    $words = explode(' ',$text);
    //echo $text;
    //echo $words;
    //echo json_encode($words);
    //die;
    
    function create_node($w,$id){
        return ['word'=>$w,'count'=>1,'left'=>null,'right'=>null,'id'=>$id];
    }
    
    $id = 1;
    foreach ($words as $word){
        if ($bt_head == null){
            $bt_head = create_node($word,$id++);
            
        }else {
            $current_node = &$bt_head;
            while(true){
                $cmp = strcmp($current_node['word'], $word);
                //echo $cmp.'...';
                if( $cmp < 0 ) {
                    if ($current_node['right'] == null){
                        $current_node['right'] = create_node($word,$id++);
                  //      echo $word.' right<br>';
                       break;
                    }
                    else {
                        $current_node = &$current_node['right'];
                    //    echo $word.' move right<br>';
                    //    continue;
                    }
                } 
                elseif ($cmp > 0){
                    if ($current_node['left'] == null){
                        $current_node['left'] = create_node($word,$id++);
                      //  echo $word.' left '.json_encode($current_node['left']).'<br>';
                        break;
                    }
                    else {
                        $current_node = &$current_node['left'];
                        //echo $word.' move left<br>';
                        //continue;
                    }
                }else {
                    $current_node['count'] = $current_node['count'] + 1;
                    //echo $word.' inc<br>';
                    break;
                }
            }
        }
    }
    
    //echo '{'.$id.'}';
    $result = array();
    
    function line($node){
        global $result;
        if ($node == null){
            return;
        }
        
        line($node['left']);
        array_push($result,['id'=>$node['id'],'word'=>$node['word'],'count'=>$node['count']]);
        line($node['right']);
    }
    
    //echo json_encode($bt_head).'<br>';
    line($bt_head);
    
    echo json_encode($result);//.'<br>';
    // print_r($bt_head);