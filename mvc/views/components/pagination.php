
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                <?php
                if(isset($data["no_page"])) {
                    $num = $data["no_page"];
                    $fprev = false;
                    $fnext = false;
                    $range = range(1, $data["total_page"], 1);
                    if($num > 1) {
                        echo '<li class="page-item"><a class="page-link" href="'.DOMAIN.$data["controller"].'/get/page=1">Đầu</a></li>';
                    }
                    foreach($range as $i) {
                        if($i <= $num - 2 && !$fprev) {
                            echo '<li class="page-item"><a class="page-link" href="'.DOMAIN.$data["controller"].'/get/page='.($num - 2).'">...</a></li>';
                            $fprev = true;
                        }
                        if($i == $num) {
                            echo '<li class="page-item active"><a class="page-link" href="'.DOMAIN.$data["controller"].'/get/page='.$i.'">'.$i.'</a></li>';
                        }
                        else if($i > $num - 2 && $i < $num + 2) {
                            echo '<li class="page-item"><a class="page-link" href="'.DOMAIN.$data["controller"].'/get/page='.$i.'">'.$i.'</a></li>';
                        }
                        if($i >= $num + 2 && !$fnext) {
                            echo '<li class="page-item"><a class="page-link" href="'.DOMAIN.$data["controller"].'/get/page='.($num + 2).'">...</a></li>';
                            $fnext = true;    
                        }
                    }
                    if($num < $data["total_page"]) {
                        echo '<li class="page-item"><a class="page-link" href="'.DOMAIN.$data["controller"].'/get/page='.$data["total_page"].'">Cuối</a></li>';
                    }
                }
                ?>
                </ul>
            </nav>