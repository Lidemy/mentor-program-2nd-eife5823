Event Loop 事件循環，Javascript 會以一個類似迴圈的方式來執行程式碼。 所以針對以下程式碼:

```
console.log(1)
setTimeout(() => {
  console.log(2)
}, 0)
console.log(3)
setTimeout(() => {
  console.log(4)
}, 0)
console.log(5)
```
程式是一行一行執行，而即將被執行的程式會先被放到任務佇列 (task queue) 中等待執行，所以上面的程式碼最先輸出的會是 1。
至於程式碼中的 setTimeout function，其本質上是瀏覽器提供的 WebAPI，所以當跑到此 function 的時候，裡面的 callback function 會先被放到 WebAPI 中，等到時間跑完就會被放到任務佇列，等待到 stack 區被執行。 而上面的 setTimeout function 需要等待的時間是 0 秒，但即使如此，他們還是要等其他程式碼執行完才輪到他們，所以依照順序輸出會是 1 3 5 2 4。