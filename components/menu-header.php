<?php
    function drawTopMenu($page) {
        echo '
        <div class="menu_panel">
            <div class="main-wrapper">
                <ul id="topMenu">';
                    echo '<a href=".\"><li';
                    if($page == "index") {
                        echo ' id="currentSection"';
                    }
                    echo '>Задание 1</li></a>';

                    echo '<a href=".\task2.php"><li';
                    if($page == "task2") {
                        echo ' id="currentSection"';
                    }
                    echo '>Задание 2</li></a>';
                echo '</ul>
            </div>
        </div>
        ';
    }
?>