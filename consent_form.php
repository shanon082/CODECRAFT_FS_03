<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Guide Consent Form</title>
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
    h2, h3 {
      text-align: center;
    }
    p {
      margin: 10px 0;
      line-height: 1.5;
    }
    ul {
      padding-left: 20px;
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
  <h2>SOROTI UNIVERSITY</h2>
  <h3>SCHOOL OF ENGINEERING AND TECHNOLOGY</h3>
  <h4><strong>DEPARTMENT:</strong> ___________________________________________</h4>

  <h4>GEC4101 - RESEARCH PROJECT</h4>
  <h3>Project Supervisor Consent Form - ..... COHORT</h3>

  <p><strong>Project Title:</strong>  </p>

  <h4>Student Information:</h4>
  <p><strong>Student Name:</strong>  </p>
  <p><strong>Registration Number:</strong> </p>

  <h4>Project Overview:</h4>
  <p>
        
  </p>

  <h4>Role of the Supervisor:</h4>
  <p>As the Supervisor for this project, the undersigned agrees to:</p>
  <ul>
    <li>Provide necessary guidance, support, and feedback throughout the course of the project.</li>
    <li>Help the student set and adhere to deadlines.</li>
    <li>Evaluate progress at various stages and offer constructive advice.</li>
    <li>Assist in problem-solving and offer technical and theoretical expertise as needed.</li>
    <li>Review the final report and give feedback prior to submission.</li>
    <li>Approve the final submission of the student’s detailed project report for review by the department's evaluation committee / External examiner(s).</li>
  </ul>

  <h4>Acceptance by the Project Supervisor</h4>
  <p>
    I ......., hereby agree to act as the project guide for the above-mentioned project.
    I commit to offering my expertise, guidance, and time to support the student in the successful completion of this project.
  </p>

  <p><strong>Signature of Supervisor:</strong> _____________________________________</p>
  <p><strong>Date:</strong> ___________ </p>
  <p><strong>Supervisor’s Full Name:</strong>  </p>
  <p><strong>Designation:</strong> ___________________________________________</p>
  <p><strong>Department:</strong>  </p>
  <p><strong>Contact Information:</strong> +256-</p>

  <h4>Responsibilities of the Student</h4>
  <ul>
    <li>Complete the project as per the approved schedule and follow the guidance provided.</li>
    <li>Regularly report progress and seek guidance in case of challenges.</li>
    <li>Submit the final project report for review and approval by the guide before final submission.</li>
  </ul>

  <h4>Acceptance by the Student</h4>
  <p>
    I,   confirm my understanding of the responsibilities outlined above and commit
    myself to completing the project under the guidance of my faculty supervisor.
  </p>

  <p><strong>Student Name:</strong>  </p>
  <p><strong>Signature:</strong> ____________________________________________</p>
  <p><strong>Date:</strong> _______  </p>
  <p><strong>Contact Information:</strong>  </p>
</div>

<button class="btn" onclick="downloadAsWord()">Download as Word</button>

<script>
  function downloadAsWord() {
    const header = `
      <html xmlns:o='urn:schemas-microsoft-com:office:office'
            xmlns:w='urn:schemas-microsoft-com:office:word'
            xmlns='http://www.w3.org/TR/REC-html40'>
      <head><meta charset='utf-8'><title>Consent Form</title></head><body>`;
    const footer = "</body></html>";
    const sourceHTML = header + document.getElementById("word-content").innerHTML + footer;

    const source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(sourceHTML);
    const fileDownload = document.createElement("a");
    document.body.appendChild(fileDownload);
    fileDownload.href = source;
    fileDownload.download = 'Guide_Consent_Form.doc';
    fileDownload.click();
    document.body.removeChild(fileDownload);
  }
</script>

</body>
</html>
