## 請找出三個課程裡面沒提到的 HTML 標籤並一一說明作用。
1. `<br>`: 使用 `<br>` 可以達到換行的效果
2. `<video>` : 使用此標籤可以在網頁裡面加上影片，並可利用 controls 屬性讓影片有基本播放功能
3. `<strong>` : 可以讓放在標籤裡的文字有粗體的效果

## 請問什麼是盒模型（box modal）
在 CSS 的世界裡，每個元素都可以被視為是一個 box。 因此在製作網頁時可以利用此特性來放置元素及排版。 而這些特性有如下幾項:
1. display inline or block
2. margin: 即與瀏覽器邊緣的間距，可設定上下左右的數值來調整
3. padding: 元素內容周圍的空間，即內邊距，可設定上下左右的數值來調整
4. border: 元素外圍的邊框

## 請問 display: inline, block 跟 inline-block 的差別是什麼？
1. display inline: 元素會有 inline 的特性，只會佔據元素本身大小的空間，可與其他 inline 元素在同一行。 但其高度及上下邊距不可改變。
2. display block: 元素會有 block 的特性，block 通常可以當作其他元素的容器，但會有佔據一整行空間的特性。其高度及邊距都可以進行設定。
3. display inline-block: 元素同時會有 block 及 inline 的特性，不僅可以調整高度及邊距，也可與其他元素在同一行。

## 請問 position: static, relative, absolute 跟 fixed 的差別是什麼？
1. position static: 元素被定位的位置是依照瀏覽器的預設值自動排版
2. position relative: 可以設定上下左右屬性，使元素依定位點相對地調整其所在位置，且不會影響其他元素原本的位置。
3. position absolute: 和 relative 的定位有點類似，但其定位點是依其所處上層容器的相對位置，如果上層容器沒有可被定位的元素，此時定位點就是相對於 body 元素。
4. position fixed: 即固定定位，無論瀏覽器頁面如何捲動，元素還是會固定在相同的位置。
