<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TikTok Social Stream</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Social Media Stream</h1>
            <p>Stay connected with our latest updates and posts from all platforms</p>
            
            <div class="status">
                <div class="status-dot"></div>
                Live feeds updating in real-time
            </div>
        </div>

        <!-- Two Column Layout for TikTok Feeds -->
        <div class="two-column-layout">
            <div class="column">
                <div class="feed-wrapper">
                    <div class="feed-title">
                        <i class="fab fa-tiktok"></i>
                        Trending TikTok Hashtags
                    </div>
                    <div class="powr-container">
                        <div class='sk-ww-tiktok-hashtag-feed' data-embed-id='25619777'></div>
                    </div>
                </div>
            </div>
            
            <div class="column">
                <div class="feed-wrapper">
                    <div class="feed-title">
                        <i class="fab fa-tiktok"></i>
                        Popular TikTok Content
                    </div>
                    <div class="powr-container">
                        <div class='sk-ww-tiktok-hashtag-feed' data-embed-id='25619773'></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="instructions">
            <h3>About This Dashboard</h3>
            <ul>
                <li>Real-time TikTok feeds from SociableKit</li>
                <li>Automatically updates with latest content</li>
                <li>Dark theme optimized for extended viewing</li>
            </ul>
        </div>

        <div class="footer">
            <p>Powered by SociableKit | TikTok feeds update automatically</p>
        </div>
    </div>

    <script src='https://widgets.sociablekit.com/tiktok-hashtag-feed/widget.js' defer></script>
</body>
</html>