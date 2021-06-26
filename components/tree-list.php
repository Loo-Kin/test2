<?php
    function createFolderWithSubfolders($folder = null) {
        if(is_null($folder)) {
            $text = file_get_contents("data/json.json");
            $folder = json_decode($text, false);
        }
        $result ='';
        foreach ($folder as $key => $value) {
            // создаём подпапку
            if(property_exists( $value, 'isFolder') && $value -> isFolder) {
                createFolderWithSubfolders($value -> children);
                $result .= '<div class="accordion">
                        <div class="accordion__wrapper">
                            <div class="accordion__item">
                                <input checked="checked" class="checkbox-xs_block" type="checkbox"> <i>&nbsp;</i>
                                <div class="accordion__title">
                                    <div>' . $value -> title . '
                                    </div>
                                </div>
                                <div class="accordion__content">
                                    '. createFolderWithSubfolders($value -> children) . '
                                </div>
                            </div>
                        </div>
                    </div>';
            }
            
            // создаём конечные узлы
            else {
                $result .= '<div class="tree-list__item">' . $value -> title . '</div>';
            }
        }
        return $result;
    }
?>