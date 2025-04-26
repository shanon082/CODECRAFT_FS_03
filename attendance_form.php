<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Fortnight Attendance Form</title>
  <style>
    body {
      font-family: 'Times New Roman', serif;
      background: #f4f4f4;
      padding: 20px;
    }
    .content {
      background: white;
      padding: 20px;
      max-width: 800px;
      margin: auto;
      border: 1px solid #ccc;
    }
    .btn {
      margin: 20px auto;
      display: block;
      background-color: #007bff;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
    }
    .btn:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>

<div class="content" id="word-content">
  <h2 style="text-align:center;">SOROTI UNIVERSITY</h2>
  <h3 style="text-align:center;">School of Engineering and Technology</h3>
  <p><strong>Department:</strong>  </p>
  <p><strong>Project Title:</strong>  </p>
  <p><strong>Supervisor:</strong>  </p>
  <p><strong>Date of Submission:</strong>  </p>

  <table style="width: 100%; border-collapse: collapse;" border="1">
    <thead>
      <tr>
        <th style="border:1px solid black; padding: 8px;">S No</th>
        <th style="border:1px solid black; padding: 8px;">Roll No</th>
        <th style="border:1px solid black; padding: 8px;">Name</th>
        <th style="border:1px solid black; padding: 8px;">Week 1</th>
        <th style="border:1px solid black; padding: 8px;">Week 2</th>
        <th style="border:1px solid black; padding: 8px;">Total</th>
        <th style="border:1px solid black; padding: 8px;">Supervisor Signature</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="border:1px solid black; padding: 8px;"> </td>
        <td style="border:1px solid black; padding: 8px;"> </td>
        <td style="border:1px solid black; padding: 8px;"> </td>
        <td style="border:1px solid black; padding: 8px;"> </td>
        <td style="border:1px solid black; padding: 8px;"> </td>
        <td style="border:1px solid black; padding: 8px;"> </td>
        <td style="border:1px solid black; padding: 8px;">________________</td>
      </tr>
    </tbody>
  </table>

  <p><strong>Brief Summary of Work carried out during last 2 weeks:</strong></p>
  <p>
    
  </p>

  <br><br>
  <p><strong>Signature of Supervisor:</strong> _______________________</p>
</div>

<button class="btn" onclick="downloadAsWord()">Download as Word</button>

<script>
  function downloadAsWord() {
    const header = `
      <html xmlns:o='urn:schemas-microsoft-com:office:office'
            xmlns:w='urn:schemas-microsoft-com:office:word'
            xmlns='http://www.w3.org/TR/REC-html40'>
      <head><meta charset='utf-8'><title>Document</title></head><body>`;
    const footer = "</body></html>";
    const content = document.getElementById("word-content").innerHTML;
    const sourceHTML = header + content + footer;

    const source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(sourceHTML);
    const fileDownload = document.createElement("a");
    document.body.appendChild(fileDownload);
    fileDownload.href = source;
    fileDownload.download = 'Fortnight_Attendance_Form.doc';
    fileDownload.click();
    document.body.removeChild(fileDownload);
  }
</script>

</body>
</html>
