<?php
$title = "Proposal Letter";
$proposal_id = $_GET['proposal_id'];

include 'includes/header-new.php';
include 'connect.php';

$sql = "SELECT * FROM proposals WHERE proposal_id = '$proposal_id'";

// echo $sql; 
$result = mysqli_query($conn, $sql);

if (mysqli_error($conn)) {
    $message = "<p>There was a problem searching</p>";
} else {
    while ($row = mysqli_fetch_assoc($result)) {
        $proposal_letter = $row['proposal_letter'];
    }
}

?>
  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>


<div class="container">
<?php 
$display = "";
$display .= "<h3>Current Letter:</h3>";
$display .= "$proposal_letter";
echo "Current Letter: $proposal_letter" 
?>

<form action="change-letter-submit.php?proposal_id=<?php echo $proposal_id ?>" method="POST" class="needs-validation"
    novalidate>



       <!--
            <div class="form-group">

        <label for="new-letter">Change Proposal Letter</label>
        <input type="textarea" class="form-control" id="new-letter" name="new-letter" placeholder="" required>
        <div class="invalid-feedback">
            Please provide a valid text input
        </div>
            </div>

-->

<div class="form-group bg-light text-dark">
    <label for="personalLetter">Personal Letter:</label>
    <div id="editor-container"></div>
    <textarea id="personalLetter" name="personalLetter" class="d-none"></textarea>
</div>

    <a href='proposal-details.php?proposal_id=<?php echo $proposal_id ?>' class='btn btn-danger'>Go Back</a>
    <input type="submit" value="Submit" class="btn btn-primary">

</form>
</div>

<!-- Quill Text Editor JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
  var quill = new Quill('#editor-container', {
    theme: 'snow',
    placeholder: 'Write a letter to the client..',
    modules: {
      toolbar: [
        [{ 'header': [1, 2, false] }],
        ['bold', 'italic'],
        ['link', 'blockquote', 'code-block', 'image'],
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        [{ 'script': 'sub'}, { 'script': 'super' }],
        [{ 'indent': '-1'}, { 'indent': '+1' }],
        [{ 'direction': 'rtl' }],
        [{ 'size': ['small', false, 'large', 'huge'] }],
        [{ 'color': [] }, { 'background': [] }],
        [{ 'font': [] }],
        [{ 'align': [] }],
        ['clean']
      ]
    }
  });



  // Update hidden input on form submission
  var form = document.querySelector('form');
  form.onsubmit = function() {
    var html = quill.root.innerHTML;
    document.getElementById('personalLetter').value = html;
  };
</script>