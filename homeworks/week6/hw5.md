## 請說明 SQL Injection 的攻擊原理以及防範方法

1. SQL Injection 稱為 SQL 資料隱碼攻擊，即攻擊者可透過更改 SQL 語法，或以加入特殊指令的方式，在未設定過濾惡意程式碼的情況下，伺服器資料庫會直接接收使用者輸入的 SQL 指令，並執行攻擊代碼，使駭客可以擅自盜走、修改、挪動或刪除資料。

2. 防範方法: 在使用 SQL 語法時加入 prepared statement，以防止使用者輸入一些特殊指令進到資料庫。

## 請說明 XSS 的攻擊原理以及防範方法

1. 全名為 Cross-Site Scripting，跨網站指令碼攻擊。 攻擊原理很簡單，就是在別人的網站上執行 Javascript 指令，例如利用 `<script>`標籤就可以輕易在網站上執行 Javasvript，常用於釣魚網站，或是可竊取其他使用者資料。

2. 防範方法: 可利用 PHP 所提供的 htmlspecialchars() 函式來跳脫，使用者輸入的惡意指令會變成純文字，而不會執行。	


## 請說明 CSRF 的攻擊原理以及防範方法
1. CSRF (Cross Site Request Forgery) 中文為跨站請求偽造，攻擊者會利用用戶登陸原網站後，由瀏覽器所儲存的 Cookies，在 Cookies 尚未過期的期間，使用戶造訪危險網站並點擊攻擊者所提供的連結，隨後會向原網站發送某功能的 request，而原網站的伺服器收到後就會認為這是用戶的合法操作。 

2. 防範方法: 可以從三個不同的角度來預防。 從使用者的角度，可以在每次網頁瀏覽後就登出網站。 至於伺服器端的防禦，第一種方法為檢查 Request header 的 Referer，看看這個 Request 是不是從合法的網域過來，但這並不是一個很好的方法。 第二種方法是加上圖形或簡訊驗證碼，缺點是使用者可能會覺得麻煩。 第三種方法是 Double Submit Cookie，由伺服器產生一組隨機的 token，並加在 form 上面以及存在 cookie 裡，當使用者點擊後伺服器會去比對兩個地方的 token 值是否相同。 最後一個是從瀏覽器的角度來預防，例如 Google Chrome SameSite cookie 功能。

## 請舉出三種不同的雜湊函數

1. MD5: MD5 全名為 Message-Digest Algorithm 5，訊息摘要演算法。是一種單向字串雜湊演算 (Hashing)，它可以將所給予的任何長度字串，利用 MD5 雜湊演算法，獲得一個長度為 128 位元（32 個十六進制數字）的計算結果。但由於 MD5 發生碰撞的機率高，安全性有疑慮，現在已不被廣泛使用。

2. SHA: 全名為 Secure Hash Algorithm ，安全雜湊演算法。 是一種能計算出一個數位訊息所對應到的，長度固定的字串（又稱訊息摘要）的演算法，且輸入的訊息不同，其對應到不同字串的機率很高。 SHA 也是FIPS所認證的五種安全雜湊演算法。 SHA 的家族包含 SHA-1、SHA-224、SHA-256、SHA-384，和SHA-512。SHA-1 曾被視為 MD5 的後繼者，但其安全性現被密碼學家嚴重質疑，因此有 SHA-2的誕生。 但由於其演算法基本上與 SHA-1 仍相似，雖目前還沒有被快速破解成功的案例，有些人還是開始發展其他替代的雜湊演算法。

3. bcrypt: 是一個適應性的雜湊函數，特別被用於密碼的儲存而設計。 它可以輸出包含密碼的 salt 與 work factor ，所以系統設計者可以一直使用bcrypt，只要藉由提高work factor就可以增加運算所需的時間，不用擔心使用者無法登入系統。
因此若想要設計強健又容易使用的密碼系統，可使用 bcrypt。

參考連結: https://gwokae.mewggle.com/wordpress/2012/07/%E7%BF%BB%E8%AD%AF-%E5%AE%89%E5%85%A8%E7%9A%84%E5%84%B2%E5%AD%98%E5%AF%86%E7%A2%BC-storing-passwords-securely/ & 維基百科


## 請去查什麼是 Session，以及 Session 跟 Cookie 的差別

Session 是負責記錄在瀏覽器伺服器端上的使用者訊息，有點像通行證機制。 其會在一個用戶完成身分認證後，存下所需的用戶資訊，接著產生一組對應的 id，存入 cookie 後傳回用戶端。 而此 id 必須要是獨特的，重複機率非常低。 當下次用戶端發送請求時，如帶有該 id 資訊，伺服器即會認為該請求來自於該名使用者，以達到驗證用戶的目的。

Session 與 Cookie 的差別在，Cookie 只是一個存放用戶資訊的東西，而 Session 則是一個驗證機制。

參考連結: https://blog.hellojcc.tw/2016/01/12/introduce-session-and-cookie/

## `include`、`require`、`include_once`、`require_once` 的差別

`require` 這個函式通常會被放在檔案的開頭，讀取 require 所引入的檔案，使其成為程式碼的一部份。

`include` 功能與 `require` 相同，但通常使用於程式的流程敘述中，例如 if...else 等。 include 可用在迴圈，但 require 不行。

`include_once`、`require_once` 功能如同上述，唯一差別在於會在引入檔案前，檢查檔案是否已在其他地方被引入。 若有就不會重複引入!

參考連結: http://jonas1011.pixnet.net/blog/post/24303632-%5Bphp%5Drequire-%E5%92%8C-include