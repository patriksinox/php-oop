const filter = document.querySelector(".meno");
const allStudents = document.querySelectorAll(".hacko");
const allStudentsArray = Array.from(allStudents);
const div = document.querySelector(".allStudents-div");

const studentsObject = allStudentsArray.map((student, i) => {
  const meno = student.querySelector("h3").textContent;
  const link = student.querySelector("a");

  return {
    id: i,
    studentName: meno.toLowerCase().trim(),
    studentLink: link,
  };
});

filter.addEventListener("input", () => {
  let hodnota = filter.value.toLowerCase();

  const novePole = studentsObject.filter((el) => {
    if (el.studentName.includes(hodnota)) return el;
  });

  div.textContent = "";

  novePole.map((el) => {
    const newDiv = document.createElement("li");
    newDiv.classList.add("hacko");

    const newH2 = document.createElement("h3");
    newH2.textContent = el.studentName;

    newDiv.append(newH2);
    newDiv.append(el.studentLink);

    div.append(newDiv);
  });
});
