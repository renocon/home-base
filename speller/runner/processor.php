<?php
    $text = $POST['text_input'];
    
    $bt_head = null;
    
    $words = explode(' ',$text);
    
    function create_node($w){
        return ['word'=>$w,'count'=>1,'left'=>null,'right'=>null];
    }
    
    foreach ($words as $word){
        if ($bt_head == null){
            $bt_head = create_node($word);
        }else {
            $current_node = $bt_head;
            while(true){
                $cmp = strcmp($current_node['word'], $word);
                if( $cmp > 0 ) {
                    if ($current_node['right'] == null){
                        $current_node['right'] = create_function($word);
                        break;
                    }
                    else $current_node = $current_node['right'];
                } 
                elseif ($cmp < 0){
                    if ($current_node['left'] == null){
                        $current_node['left'] = create_function($word);
                        break;
                    }
                    else $current_node = $current_node['left'];
                    continue;
                }else {
                    $current_node['count'] += 1;
                    break;
                }
            }
        }
    }
    
    $result = array();
    
    function line($node){
        global $result;
        if ($node == null){
            return;
        }
        
        line($node['left']);
        array_push($result,['word'=>$node['word'],'count'=>$node['count']]);
        line($node['right']);
    }
    
    line($bt_head);
    
    return json_encode($result);