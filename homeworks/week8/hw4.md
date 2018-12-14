## 什麼是 DNS？Google 有提供的公開的 DNS，對 Google 的好處以及對一般大眾的好處是什麼？

1. DNS 全名為 Domain Name Server，Domain Name 意思是網域名稱，如網址 googole.com。 當使用者在瀏覽器的網址搜尋列輸入 Domain Name 後，瀏覽器必須先去一台有 Domain Name 和 IP 對應資料的主機查詢該電腦的 IP，這台供瀏覽器查詢的主機就是 DNS。
可以理解為必須要有 DNS，瀏覽器才能查詢到伺服器的 IP 在哪裡。

2. Google Public DNS 是Google面對大眾推出的一個公共免費域名解析服務。 而使用 Google Public DNS 對用戶的好處是，因為其更新速度快，所以能讓用戶上網的速度更快。另外 Google Public DNS 也會幫忙擋下將用戶導向惡意網站的攻擊。
而我想對於 Google 的好處應該是，Google 現在已經是全世界最多人使用的搜尋網站，網友平均每天要進行數百個DNS查詢，有些複雜的網頁在開始下載前更要求數次的DNS查詢，這會拖慢瀏覽速度，Google Public DNS 可以改善處理速度，同時避免DNS伺服器受到快取污染以強化安全性；遵循DNS標準並提供使用者精確的回應來提昇可靠性。 
另一方面，Google 也可以得到大眾瀏覽甚麼網站的資料，對於對於這些收集的資料對 Google 會很有幫助。

參考連結: https://ithome.com.tw/node/58488


## 什麼是資料庫的 lock？為什麼我們需要 lock？

1. 資料庫的 lock 意思是將資料庫的某個表格或是表格中的某欄暫時鎖住，等到前一筆的 query 執行完沒問題後再繼續執行下一個 query。 語法是在 query 後面加上 for update。

2. 當資料庫在收到多個 requests 且這些 requests 幾乎是同時抵達，此時資料庫會同時執行多筆 commits，這樣的結果會造成多筆交易彼此互相影響，為了交易的一致性與隔離性，必須將後面的交易先鎖住，等到前面的交易執行完沒問題後再執行下一筆交易。 


## NoSQL 跟 SQL 的差別在哪裡？

NoSQL 是資料庫的一種，而 SQL 則是對資料庫下指令的程式語言，即 CRUD，所以 SQL 不是一個資料庫系統。 NoSQL 為非關聯式資料庫，其存取資料的格式通常是 JSON。

參考連結: https://ithelp.ithome.com.tw/articles/10187443


## 資料庫的 ACID 是什麼？

在關聯式資料庫中，Transaction 是一個重要特性，裡面包含多個 query，而全部的 query 都必須要執行成功才算是完成一筆 Transaction。而為了維持 Transaction 的正確性，就必須要具備 ACID 四種特性:

1. Atomicity 元子性: 一筆交易裡只要有一個 SQL 執行失敗則此交易失敗
2. Consistency 一致性: 交易執行前後的資料必須維持一致
3. Isolation 隔離性: 不同的交易執行時不能彼此干擾
4. Durability 持久性: 一旦交易完成後，資料必須儲存於儲存媒介中。   