<?php
$thispage = $PHP_SELF;
$num = $totalcount; // number of items in list
$per_page = 4; // Number of items to show per page
$showeachside = 5; //  Number of items to show either side of selected page
if (empty($pageno)) {
    $pageno = 0;
} 
$max_pages = ceil($num / $per_page); // Number of pages
$cur = ceil($pageno / $per_page) + 1; // Current page number
?>
<table>
    <tr> 
        <td>
            <?php
            if (($pageno - $per_page) >= 0) {
                $next = $pageno - $per_page;
                ?>
<!--                <a href="<?php print("$thispage" . ($next > 0 ? ("?pageno=") . $next : "")); ?>">Prev</a> -->
                <?php
            }
            ?>
            <?php
            $eitherside = ($showeachside * $per_page);
            if ($pageno + 1 > $eitherside)
                print ("<a href='#'>. . . .</a>");
            $pg = 1;
            for ($y = 0; $y < $num; $y+=$per_page) {
                $class = ($pg == (($pageno/$per_page)+1)) ? "pageselected" : "";
                if($pageno==0 && $pg==1){
                    $class = "pageselected" ;
                }
                else if($pageno==1 && $pg==1){
                    $class = "pageselected" ;
                }
                if (($y > ($pageno - $eitherside)) && ($y < ($pageno + $eitherside))) {
                    ?>
                    <a class="<?php print($class); ?>" href="<?php print("$thispage" . ($y > 0 ? ("?pageno=") . ($y) : ("?pageno=") .($y+1))); ?>"><?php print($pg); ?></a> 
                    <?php
                }
                $pg++;
            }
            if (($pageno + $eitherside) < $num)
                print ("<a href='#'>. . . .</a>");
            ?>
            <?php
            if ($pageno + $per_page < $num) {
                ?>
<!--                <a href="<?php print("$thispage?pageno=" . max(0, $pageno + $per_page)); ?>">Next</a> -->
                <?php
            }
            ?>
        </td>
    </tr>
</table>