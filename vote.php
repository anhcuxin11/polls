<?php
include 'functions.php';
// Connect to          $_SESSION["username"]
session_start();
$pdo = pdo_connect_mysql();
$msg='';
// If the GET request "id" exists (poll id)...
if (isset($_GET['id'])) {
    // MySQL query that selects the poll records by the GET request "id"
    $stmt = $pdo->prepare('SELECT * FROM polls WHERE id = ?');
    $stmt->execute([ $_GET['id'] ]);
    // Fetch the record
    $poll = $stmt->fetch(PDO::FETCH_ASSOC);
    // Check if the poll record exists with the id specified
    if ($poll) {
        // MySQL query that selects all the poll answers
        $stmt = $pdo->prepare('SELECT * FROM poll_answers WHERE poll_id = ?');
        $stmt->execute([ $_GET['id'] ]);// ? = $_GET['id']//////////////////////////
        // Fetch all the poll anwsers
        $poll_answers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //$t = $poll_answers[0]['title'];
        // If the user clicked the "Vote" button...
        if (isset($_POST['poll_answer'])) {
            
            $query = "SELECT * FROM status WHERE id_poll = :id_poll AND user = :user";
            $statement = $pdo->prepare($query);
            $statement->execute(
                array(
                    'id_poll' => $_GET['id'],
                    'user' => $_SESSION["username"]
                )
            );
            $count = $statement->rowCount();
            if($count>0){
                $answers = $statement->fetchAll(PDO::FETCH_ASSOC);
                $d = $answers[0]['poll_answer'];              
                $msg = "Bạn đã vote: '$d' ";
                
            }
            else{
                // Update and increase the vote for the answer the user voted for
                $stmt = $pdo->prepare('UPDATE poll_answers SET votes = votes + 1 WHERE id = ?');
                $stmt->execute([ $_POST['poll_answer'] ]);

                $stmt = $pdo->prepare('SELECT * FROM poll_answers WHERE id = ?');
                $stmt->execute([ $_POST['poll_answer'] ]);// ? = $_GET['id']//////////////////////////
                // Fetch all the poll anwsers
                $poll_title = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Redirect user to the result page
                $stmtk = $pdo->prepare('INSERT INTO status (id_poll, poll_answer, user) VALUES (?, ?, ?)');
                $stmtk->execute([ $_GET['id'], $poll_title[0]['title'], $_SESSION["username"] ]);

                header('Location: result.php?id=' . $_GET['id']);
                exit;
            }
            
        }
    } else {
        exit('Poll with that ID does not exist.');
    }
} else {
    exit('No poll ID specified.');
}
?>

<?=template_header('Poll Vote',$_SESSION["us"])?>

<div class="content vote">
	<h2><?=$poll['title']?></h2>
	<p><?=$poll['description']?></p><hr>
    <form action="vote.php?id=<?=$_GET['id']?>" method="post">
        <?php for ($i = 0; $i < count($poll_answers); $i++): ?>
        <label>
            <input type="radio" name="poll_answer" value="<?=$poll_answers[$i]['id']?>"<?=$i == 0 ? ' checked' : ''?>>
            <?=$poll_answers[$i]['title']?>
        </label>
        <?php endfor; ?>
        <div>
            <input type="submit" value="Vote">
            <a href="result.php?id=<?=$poll['id']?>">View Result</a>
        </div>
        <?php if ($msg): ?>
        <p><?=$msg?></p>
        <?php endif; ?>
    </form>
</div>

<?=template_footer()?>