<?php
$production = false;
$useSample = true;

$accessToken = $production ? "PRODUCTION-KEY" : "AgAAAA**AQAAAA**aAAAAA**Rz3BXA**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wFk4aiCJCBpA2dj6x9nY+seQ**I+gEAA**AAMAAA**tW/4o2Tl9SiHknfGgVRMnfzABp3yR606fIgXs9iWP5sAVYPXEV8Thqny38nMnbRQobWo4zTUbIjFV/m8VTANEv49FKk+uCB+Vkw83Wenk5AupRbB/IEkt0+k1D8Rx61q9eeBihl6x5w0fwvhQmX98jVvCmlUaeojE+0PzofddSNVhl5SD7eV6Rdtq8BDGc35CIU4lq42QyaL2hDrWmIF14GDoFoYmmlmWScUFzwMy5fBbAlV1Q81epnrZ9bMPkDcJ5Ih6rrRD+hr+mzrvfsfqwrZe2gEjXUel8bWQ/I2xZbtTCJUblrIoCQtG2zCAWdqU+d08bAmAqpYLMc88Yx4OejTz5wB/Zf9cAIq2Zn4jhB1v2uE2Clx6J780zzkdegsbiblYLtGWXMOnHlUzdAT34ughD1nYBSpeU8uJp2WmpL+1v6/PVa4E2VLOlA4KsDLWidqWfFzSHN+rCx5ZA8ltn7EGiSF95A1n+gpjZuKWOmjnxI1QMWjVvO1wAC5SlRSvw8mL7r7rusOkoIZsWgWlVBqtq2FSslfEY9FaofiY4yQbb9ZOR9nALJGULzz4M2LXA5Eg5wJqbok7bwFeKJDgbelh6H0TtFwo3JIyW9SGAKsbOJ8WbijZbror7jd+RQA6R3Kf/XZfq/7I1A9aJfOr466Yb+HdvsWkpOfT61qNhvhHJQOM4I3qZcXV+d8ER4WaGIS5QOqZytkcmF0/5kw5y9wRhhTp3aRk1WKHnXR75PvLttM3npEFRzKeJNw6CJs";


$dbHost 	= "localhost";
$dbUsername 	= "root";
$dbPassword 	= "439498290533840204";
$dbName 	= "order-management";

$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

$octoPiAPIKey = "A5E9F2B3354B45A49AAFD19E407E7C71";

$telegramAPIKey = '635318048:AAFcHRTCXeROg9p6okGPBZahv3-i_hfBBQ0';
$telegramChannelID = '466711118';

?>
