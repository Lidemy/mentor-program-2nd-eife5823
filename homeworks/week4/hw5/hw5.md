## hw5：簡答題

1. 什麼是 DOM？
全名為 Document Object Model，是一個將 HTML 文件以樹狀結構來表示的模型，組合起來的樹狀圖，稱為 DOM Tree。
- 其中每個 HTML 的 tag，可被看作是一個節點（NODE）。
- Javascript 就是透過 DOM 提供的 API 來對 HTML 做存取與操作。
- DOM 是由瀏覽器所提供，讓 Javascript 來操縱 HTML 的橋樑，故不在 Javascript 的規範內。

2. 什麼是 Ajax？
全名為 Asynchronous JavaScript and XML，是網頁利用用來達成與 server 非同步互動行為的機制，簡單來說就是透過瀏覽器提供的 API ，可不換頁就與伺服器溝通、存取資料。
至於非同步是指，發送 request 後，程式可以邊繼續做自己的事，同時等 response 及結果回來。

3. HTTP method 有哪幾個？有什麼不一樣？
(1) GET: 取得想要的資料
(2) POST: 新增一項資料
(3) PUT: 新增一項資料，如有已經存在的資料會覆蓋過去
(4) HEAD: 和 GET 相同，但 HEAD 只會取得 HTTP header 的資料
(5) PATCH: 附加新的資料在已經存在的資料後面，相當於更新這筆資料
(6) DELETE: 刪除資料

參考連結: https://data-sci.info/2015/10/24/%E5%B8%B8%E8%A6%8B%E7%9A%84http-method%E7%9A%84%E4%B8%8D%E5%90%8C%E6%80%A7%E8%B3%AA%E5%88%86%E6%9E%90%EF%BC%9Agetpost%E5%92%8C%E5%85%B6%E4%BB%964%E7%A8%AEmethod%E7%9A%84%E5%B7%AE%E5%88%A5/

4. `GET` 跟 `POST` 有哪些區別，可以試著舉幾個例子嗎？
- 使用 GET 傳送資料，從瀏覽器的網址列就可以清楚看見要傳送的資料，所以不適合傳送敏感資訊，例如帳號、密碼等。 而 POST 則會將資料放在 body 進行傳送，也可以放比較多資料。
- 使用 GET 傳送資料，會自動在網址列後面加上參數，但 POST 的網址列不會有變化。

參考連結: https://blog.toright.com/posts/1203/%E6%B7%BA%E8%AB%87-http-method%EF%BC%9A%E8%A1%A8%E5%96%AE%E4%B8%AD%E7%9A%84-get-%E8%88%87-post-%E6%9C%89%E4%BB%80%E9%BA%BC%E5%B7%AE%E5%88%A5%EF%BC%9F.html 

5. 什麼是 RESTful API？
REST 全名為 Resource Representational State Transfer，可譯為具象狀態傳輸。 RESTful 是一種設計規範， 其指的是網路中Client端和Server端的一種呼叫服務形式，透過既定的規則來取得、新增、修改和刪除資源，剛好對應到 HTTP Method。 且RESTful API 擁有很好的可讀性，

參考連結: https://github.com/twtrubiks/django-rest-framework-tutorial/tree/master/RESTful-API-Tutorial

6. JSON 是什麼？

JSON 是個以純文字為基底，去儲存和傳送簡單結構資料的格式。 其可以透過特定格式儲存任何資料（包含數字、字串、陣列及物件），也可以透過陣列或物件傳送較複雜的資料。
所以一旦建立了 JSON 資料，即可很簡單地與其他程式溝通或交換資料，因為其純文字格式的特性。 

7. JSONP 是什麼？
全名為 JSON with Padding，JSONP 是 JSON 格式的另一種使用方式，最主要目的在於跨網域取得資料。 由於一些瀏覽器端的語言，會利用 Same origin policy (同網域限制) 的概念，以保障資料傳輸的安全性，此時就會需要跨網域取資料的方法，所以 JSONP 是透過動態產生 JSON 資料。

參考連結: https://ithelp.ithome.com.tw/articles/10094915

8. 要如何存取跨網域的 API？
當要存取不同網域的 API 時，瀏覽器一樣會發 request，但會把 response 擋下來，但若是想要串接的 API，它 header有 CORS 跨來源資源共享，就會允許通過，讓程式接收到 response。 所以如果有 CORS則可以優先使用，若是沒有，就使用上述提到的 JSONP，利用`<script src>`放資料在裡面，然後再利用 function 把 response 帶回來。

參考連結: Huli 的 blog. XD
