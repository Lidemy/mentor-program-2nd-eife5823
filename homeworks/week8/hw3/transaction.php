<?php

require_once('conn.php');

$in_stock = TRUE;

/* begin transaction */
$conn->autocommit(FALSE);
$conn->begin_transaction();

$stmt = $conn->prepare("SELECT * from products WHERE id = 1 for update");
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	echo $row['id'] . "amount:" . $row['amount'] . "<br>";

	if ($row['amount'] > 0) {
		$stmt = $conn->prepare("UPDATE products SET amount = amount - 1 WHERE id = 1");
		if ($stmt->execute()) {
			echo "購買成功!<br>";
		} else {
			$in_stock = FALSE;
		}
	}
}

$stmt_1 = $conn->prepare("SELECT * from products WHERE id = 2 for update");
$stmt_1->execute();
$result_1 = $stmt_1->get_result();
if ($result_1->num_rows > 0) {
	$row_1 = $result_1->fetch_assoc();
	echo $row_1['id'] . "amount:" . $row_1['amount'] . "<br>";

	if ($row_1['amount'] > 0) {
		$stmt_1 = $conn->prepare("UPDATE products SET amount = amount - 1 WHERE id = 2");
		if ($stmt_1->execute()) {
			echo "購買成功!<br>";
		} else {
			$in_stock = FALSE;
		}
	}
}

if ($in_stock === FALSE) { // 不知為何永遠無法跑到這一行
	$conn.rollback();
	echo "購買失敗!";
} else {
	$conn->commit();
}

$conn->close();

?>