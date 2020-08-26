


    <header class="page-title bg-feed">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1>Frequently Asked Questions</h1>
                </div>
            </div>
        </div>
    </header>

    <div id="myCanvasNav" class="overlay" onclick="closeNav()"></div>

    <main>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="frame">
                        
                        <div class="accordion faqs" id="faqs">
                            <ol>
                               
                               
                               <?php
							   		$counter = 1;
							   		foreach( $faq as $obj )
									{
							   ?>
                               
                               
                                <li><a href="" data-toggle="collapse" data-target="#q<?php echo $counter;?>"><?php echo $obj -> question;?></a>
                                    <div id="q<?php echo $counter;?>" class="collapse" data-parent="#faqs">
                                    <?php echo $obj -> answer;?>
                                    </div>
                                </li>
                                
                                <?php
								
								$counter ++;
									}
									
								?>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>