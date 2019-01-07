## CSS 預處理器是什麼？我們可以不用它嗎？

1. CSS 預處理器是指將非 CSS 的程式碼作一些處理讓它們可以變成 CSS 程式碼，幫助我們以程式化的方法來寫 CSS，較有效率且能減少許多重複性工作。 如 SASS、LESS 等等。

2. CSS 預處理器並不是必要一定要會的，沒有使用 CSS 預處理器也可以寫出 CSS。 但在追求工作效率以及易於維護的考量下，使用還是比較方便。


## 請舉出任何一個跟 HTTP Cache 有關的 Header 並說明其作用。

`Expires` : 可以在 HTTP Response Header 裡加上`Expires`標示這個 Cache 到期的時間，來決定瀏覽器是否重新發送 request，或是直接從 Cache 拿資料就好。  


## Stack 跟 Queue 的差別是什麼？

Stack 跟 Queue 都是資料結構的一種，但取出資料的方式不同。 Stack 的原則是 First In, Last Out 先進後出，資料是一層一層往上疊，而拿資料時只能從最上面開始拿; Queue 的概念則是像排隊一樣，所以 First In, First Out 先進先出，意思是在一個佇列中，先讀取的資料會先輸出。 


## 請去查詢資料並解釋 CSS Selector 的權重是如何計算的（不要複製貼上，請自己思考過一遍再自己寫出來）

CSS Selector 的權重指的是 CSS 套用的優先權，例如相同權重但後寫的 CSS 會覆蓋先前的 CSS; 而當兩個 Selector 同時作用在一個元素，則權重高的優先生效。

CSS 優先權還蠻容易理解的，首先最低最容易被覆蓋的是`*`，這是適用於全站的 Selector;而它的上一層則是 element 元素，像是`<div>` 、`<li>`、`<p>`、`<h1>`等等; 再上一層就是 Class 類別; 而 Class 的再上一層可想而知就是 ID; 最後階層高於 ID 的就是平常不太常使用的寫在 HTML 裡面的 CSS。 其中沒提到的還有一些偽元素，例如`nth-child()`等等，它的階層則是跟 Class 一樣，最後階層最高的就是 `!important`，人如其名標上這個的 CSS 會覆蓋其他所有的 CSS 樣式。

參考連結: https://ithelp.ithome.com.tw/articles/10196454