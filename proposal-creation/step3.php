<h2 class="mb-4">Create Proposal Letter</h2>
<?php
if (isset($_POST['existingClientID'])) {
  $existingClientID = $_POST['existingClientID'];
} else {
  $companyName = $_POST['companyName'];
  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $contactEmail = $_POST['contactEmail'];
}
$title = $_POST['title'];
$dateCreated = $_POST['dateCreated'];
?>


<div class="progress mb-4">
  <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
</div>

<div class="mt-5 text-dark">
  <form action="proposal-creation.php" method="POST" class="needs-validation" novalidate>
    <input type="hidden" name="step" value="4">
    <?php if (isset($existingClientID)) { ?>
      <input type="hidden" name="existingClientID" value="<?php echo htmlspecialchars($existingClientID); ?>">
    <?php } else { ?>
      <input type="hidden" name="companyName" value="<?php echo htmlspecialchars($companyName); ?>">
      <input type="hidden" name="firstName" value="<?php echo htmlspecialchars($firstName); ?>">
      <input type="hidden" name="lastName" value="<?php echo htmlspecialchars($lastName); ?>">
      <input type="hidden" name="contactEmail" value="<?php echo htmlspecialchars($contactEmail); ?>">
    <?php } ?>

    <input type="hidden" name="title" value="<?php echo htmlspecialchars($title); ?>">
    <input type="hidden" name="dateCreated" value="<?php echo htmlspecialchars($dateCreated); ?>">

    <div class="form-group bg-light">
      <label for="personalLetter" style="margin: 1rem;">Proposal Letter:</label>
      <div id="editor-container" style="height: 200px;"></div>
      <textarea id="personalLetter" name="personalLetter" class="d-none"></textarea>
    </div>

    <!-- Error message placed here, outside the letter box -->
    <div class="alert alert-danger mt-2" id="personalLetterError" style="display: none;">Please provide the content for the personal letter.</div>

    <div class="mt-4">
      <a onclick="history.go(-1)" class="btn btn-secondary" id="previousButton">Previous</a>
      <button type="submit" class="btn btn-primary">Next</button>
    </div>
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
        [{
          'header': [1, 2, false]
        }],
        ['bold', 'italic'],
        ['link', 'blockquote', 'code-block', 'image'],
        [{
          'list': 'ordered'
        }, {
          'list': 'bullet'
        }],
        [{
          'script': 'sub'
        }, {
          'script': 'super'
        }],
        [{
          'indent': '-1'
        }, {
          'indent': '+1'
        }],
        [{
          'direction': 'rtl'
        }],
        [{
          'size': ['small', false, 'large', 'huge']
        }],
        [{
          'color': []
        }, {
          'background': []
        }],
        [{
          'font': []
        }],
        [{
          'align': []
        }],
        ['clean']
      ]
    }
  });

  document.querySelector('form').addEventListener('submit', function(event) {
    var html = quill.root.innerHTML;
    if (html.length === 0 || quill.getText().trim() === '') {
      event.preventDefault(); // Prevent form submission
      document.getElementById('personalLetterError').style.display = 'block'; // Show the error message
    } else {
      document.getElementById('personalLetter').value = html; // Update hidden input
      document.getElementById('personalLetterError').style.display = 'none'; // Hide the error message
    }
  });

  document.getElementById('previewBtn').addEventListener('click', function() {
    var previewWindow = window.open('', '_blank');
    previewWindow.document.write('<html><head><title>Preview</title></head><body>' + quill.root.innerHTML + '</body></html>');
    previewWindow.document.close();
  });
</script>