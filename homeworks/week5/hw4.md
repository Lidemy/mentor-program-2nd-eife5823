## 資料庫欄位型態 VARCHAR 跟 TEXT 的差別是什麼

varchar 跟 text 都是適用於儲存字串的資料型態。 varchar 只能儲存長度為 8000 以下的字元，但 text 可儲存大量（高達兩億個位元組）字元資料。


## Cookie 是什麼？在 HTTP 這一層要怎麼設定 Cookie，瀏覽器又會以什麼形式帶去 Server？

Cookie 是一種小型的文字檔案，是一段由伺服器發送給瀏覽器的一小塊資料。 意思是當使用者發送 HTTP 請求後，伺服器接收到請求回傳資料時，也會回傳 Cookie，而瀏覽器會把此 Cookie 其中的資料以加密方式儲存起來，等到下一次瀏覽器在發送 request 的時候，瀏覽器會自動把所有 Cookie 放在 request 裡面帶去 Server。 在 HTTP 這一層伺服器透過 response header 的 set-cookie，命令瀏覽器設定 Cookie。

參考連結: https://progressbar.tw/posts/91 

## 我們本週實作的會員系統，你能夠想到什麼潛在的問題嗎？

會有一些可能會被駭客入侵的安全性問題，例如 XSS 攻擊，只要在我的留言版輸入程式碼就可以改變我的網站外觀。

