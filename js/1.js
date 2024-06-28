let counter = 0;
const textBlock = document.getElementById('demo');
const img = document.createElement('img');
img.src = "./images/vibe-cat.gif";

document.getElementById("btn-1").onclick = () => {
	counter++;
	if (counter % 2 === 0)
		textBlock.appendChild(img);
	else
		textBlock.innerHTML = "";
}
