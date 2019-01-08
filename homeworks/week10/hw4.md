## gulp 跟 webpack 有什麼不一樣？我們可以不用它們嗎？

1. Gulp 為任務執行工具，功能在於把任務自動化，例如壓縮圖片、JS、CSS 檔案，compile CSS, 轉換 JS 語法等等。 而 webpack 則是使用 import 將資源加載進來，因為瀏覽器無法使用 import 語法，且 webpack 的打包功能可以變成 Gulp 的任務之一。

2. 當然可以不用使用 gulp 與 webpack，但工作就會比較耗時沒有效率，因為很多功能要靠自己寫出來。


## hw3 把 todo list 這樣改寫，可能會有什麼問題？

每次都要再重新 render 畫面，即使是同樣的東西也要重新 render，比較損耗效能。

## CSS Sprites 與 Data URI 的優缺點是什麼？

1. CSS Sprites 功能是將網頁上的所有圖片結合成一個，原本每讀取一張圖片就要發送一次 HTTP request 就變成讀取所有圖片只要發送一次 HTTP request，可以加快網頁讀取速度。 但缺點在於只要把網頁等比放大，圖片就有可能會失真，而且要把所有 icon 放在同一個圖片，再自己算出定位不是很方便。 

2. Data URI 是一種檔案格式，其資料全部都是經過 base64 編碼之後，以文字的方式來儲存的，這樣的好處就是不用透過外部的檔案來載入，普遍的情境用在將圖片嵌入網頁上。 優點和 CSS Sprites 相同，可以減少 HTTP request 的數量，但缺點是因為不是真正的圖檔，所以瀏覽器沒辦法將其 cache 起來，且當檔案資料有變化時，所有內嵌它的網頁都要重新產生編碼，編碼後的檔案也會比原始資料大。

參考連結: https://medium.com/cubemail88/data-uri-%E5%89%8D%E7%AB%AF%E5%84%AA%E5%8C%96-d83f833e376d