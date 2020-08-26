

    <header class="page-title bg-news">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="category"><?php echo $faq -> category;?></h1>
                    <span>Published: <?php echo date('M d,Y', strtotime( $faq -> dated) );?></span>
                </div>
            </div>
        </div>
    </header>

    <div id="myCanvasNav" class="overlay" onClick="closeNav()"></div>

    <main class="faq-page">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-4 col-left">
                    <div class="frame recommendations share">
                        <h2>Share this story</h2>
                        <div class="sharethis-inline-share-buttons"></div>
                        
                        <div  class="related-faqs js_faq">
                        
                        </div>
                        
                    </div>
                </div>
                <div class="col-12 col-md-8 col-right">
                    <div class="frame news-article">
                    	<h2><?php echo $faq -> question;?></h2>
                        <?php echo $faq -> answer;?>
                        
                    </div>
                </div>
            </div>
            
        </div>
    </main>

