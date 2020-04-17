
<section class="ui container w-100 pb-5">
    <div class="ui w-75 pt-5 m-auto text-center">
            <div class="ui container-fluid">
            <div class="ui mt-5 row">
                <?php
                $popular=popular_event();
                shuffle($popular);
                for ($e=0;$e<3;$e++) {
                    //position 0 (Date)
                    //position 1 (Price)
                    //position 2 (starting point)
                    //position 3 (time)
                    //position 4 (image)
                    //position 5 (title)
                    $show = <<<print
                        <div class="col">
                        <a href="tour_details.php?title={$popular[$e][6]}" style="display: block">
                        <div class="ui  image ">
                        <div class="ui violet ribbon label z-index-1000 mt-1">
                                Similar
                            </div>
                            <div class="ui card">
                                <div class="content"></div>
                                <div class="image">
                                    <img src="{$popular[$e][4]}">
                                </div>
                                <div class="content">
                                    <span class="right floated">
                                        <i class="euro icon"></i>
                                        {$popular[$e][1]}</span>

                                    <span class="left floated">
                                    {$popular[$e][5]}                                   
                                    </span>

                                </div>
                                <div class="extra content ">
                                    <div class="ui large  transparent left icon input">
                                    <span class="left floated">
                                          Starting point: {$popular[$e][2]}                                   
                                      </span>
                                    <span class="right floated">
                                    Date: {$popular[$e][0]} Time: {$popular[$e][3]}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
print;
                    echo $show;
                }
                ?>
            </div>
        </div>
    </div>
</section>