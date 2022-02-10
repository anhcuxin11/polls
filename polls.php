<?php
// Include the function file 
include 'functions.php';
// Connect to MySQL
$pdo = pdo_connect_mysql();
// MySQL query that retrieves all the polls and poll answers
$stmt = $pdo->query('SELECT p.*, GROUP_CONCAT(pa.title ORDER BY pa.id) AS answers FROM polls p LEFT JOIN poll_answers pa ON pa.poll_id = p.id GROUP BY p.id');
$polls = $stmt->fetchAll(PDO::FETCH_ASSOC);
$dem = 0;

?>

<?php
session_start();
$us = "Khach";
if(isset($_SESSION["username"])){
    $us =  $_SESSION["username"];   
}
?>

<?=template_header('Polls',$_SESSION["us"])?>

<div class="content poll">
	<h2>Đây là danh sách các bình chọn</h2>
	<table Border = 1>
        <colgroup>
                <col width='5%'>              
                <col width='37%'>
                <col width='43%'>
                <col width='15%'>
        </colgroup>
        <thead>
            <tr>
                <td>STT</td>    
                <td>Title</td>
				<td>Answers</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach($polls as $poll): ?>
            <tr>
                <td><?=++$dem?></td>
                <td><?=$poll['title']?></td>
				<td><?=$poll['answers']?></td>
                <td class="actions">
					<a href="vote.php?id=<?=$poll['id']?>" class="view" title="View Poll"><i class="fas fa-eye fa-xs"></i></a>
                    <a href="result.php?id=<?=$poll['id']?>" class="po" title="Result Poll"><i class="fas fa-poll fa-xs"></i></a>
                    <a href="delete.php?id=<?=$poll['id']?>" class="trash" title="Delete Poll"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?=template_footer()?>