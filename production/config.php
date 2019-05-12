<?php
$production = true;
$useSample = false;

$accessToken = $production ? "AgAAAA**AQAAAA**aAAAAA**fLPXXA**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AFkIWmDJGKoAidj6x9nY+seQ**TtwFAA**AAMAAA**2w4ZrYmp9YIvq6PVsrba2a03+jsV3sclufSbDswU6qrfejoDyebhE6E+EWxfLr2tnvhcKsvL6E8sh2xkw/eoSxC+a0SwWSWeHr8vQr+CWoZj6qyI2vc6qa6kFfrX6Ph+sVL5M31FCuSm9yFZRntsj8kOri3/JYDI0pGYMWrEwk9aig36eHT0iM3cfgqOfQ/vfF+HtR++X2dmAVIKW42HQCweGYV4s+7Dc/5jCp3XAk34ylo7D1urK/FaMOlv52PxWqsuKefL6ddpnXWrGZSs+u9DyHgvV10RFh8Y3uuJMtpOGTNYBtjZWlQk6BYN9cqFVBc3g9XIBNbpzqwUYvB4ryd7kIIIQXtx0Td9HuEuJt7t8LGcZHy2/BYZtMflrMDgo5aJq5BVnUjR8/mFQn1M+he0+M2f2QVF51Qd7iuL3PLLioGUp5ScMIcFS1Q29bliLjJAzp64CauPwoY86d+t0iUU8UOzblotoLP4K+3ijCBQMTQHZ9yMg24w1oLZA1K4iZc/acMRLozPb+jVgyFuFFXzgkieKCoutwAVKmJ6gwb6FXxhmFD4PpKBxHx2FO8Jt8T31KHbKbN+GBl0rVCap97PF4C5SW7qb9P3dQ5WhpsT1FppyGzN6dO8pDrBF4b9y9Pz7BKWSflPoFaFIbix5ISmCevPhEd59Zi/oz53Eca8SK+TkVigXMIOXJyEbMWXIHWKhVT4SvqcNE2f9/KqhPjocmVX6faJ/qoM1zGexf3uaEzaVCygrTVQ5i+2CCww" : "AgAAAA**AQAAAA**aAAAAA**Rz3BXA**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wFk4aiCJCBpA2dj6x9nY+seQ**I+gEAA**AAMAAA**tW/4o2Tl9SiHknfGgVRMnfzABp3yR606fIgXs9iWP5sAVYPXEV8Thqny38nMnbRQobWo4zTUbIjFV/m8VTANEv49FKk+uCB+Vkw83Wenk5AupRbB/IEkt0+k1D8Rx61q9eeBihl6x5w0fwvhQmX98jVvCmlUaeojE+0PzofddSNVhl5SD7eV6Rdtq8BDGc35CIU4lq42QyaL2hDrWmIF14GDoFoYmmlmWScUFzwMy5fBbAlV1Q81epnrZ9bMPkDcJ5Ih6rrRD+hr+mzrvfsfqwrZe2gEjXUel8bWQ/I2xZbtTCJUblrIoCQtG2zCAWdqU+d08bAmAqpYLMc88Yx4OejTz5wB/Zf9cAIq2Zn4jhB1v2uE2Clx6J780zzkdegsbiblYLtGWXMOnHlUzdAT34ughD1nYBSpeU8uJp2WmpL+1v6/PVa4E2VLOlA4KsDLWidqWfFzSHN+rCx5ZA8ltn7EGiSF95A1n+gpjZuKWOmjnxI1QMWjVvO1wAC5SlRSvw8mL7r7rusOkoIZsWgWlVBqtq2FSslfEY9FaofiY4yQbb9ZOR9nALJGULzz4M2LXA5Eg5wJqbok7bwFeKJDgbelh6H0TtFwo3JIyW9SGAKsbOJ8WbijZbror7jd+RQA6R3Kf/XZfq/7I1A9aJfOr466Yb+HdvsWkpOfT61qNhvhHJQOM4I3qZcXV+d8ER4WaGIS5QOqZytkcmF0/5kw5y9wRhhTp3aRk1WKHnXR75PvLttM3npEFRzKeJNw6CJs";

$eBayAPIUrl = $production ? "https://api.ebay.com/ws/api.dll" : "https://api.sandbox.ebay.com/ws/api.dll";

$dbHost 	= "localhost";
$dbUsername 	= "root";
$dbPassword 	= "439498290533840204";
$dbName 	= "order-management";

$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

$octoPiAPIKey = "A5E9F2B3354B45A49AAFD19E407E7C71";

$telegramAPIKey = '635318048:AAFcHRTCXeROg9p6okGPBZahv3-i_hfBBQ0';
$telegramChannelID = '466711118';


$ausPostAPIKey = $production ? '48c51511-087e-476b-8de3-86d38db5e66b' : "48c51511-087e-476b-8de3-86d38db5e66b";
$ausPostPassword = $production ? 'x7e75f769bfc9b9cd470' : "x7e75f769bfc9b9cd470";
$ausPostAccount = $production ? '1016711300' : "1016711300";
$ausPostAPIUrl = $production ? 'https://digitalapi.auspost.com.au/test' : "https://digitalapi.auspost.com.au/test";

$piIPAddress = "10.0.0.37";

?>
