const deleteButtons = document.getElementsByClassName('delete-button');

for (const deleteButton of deleteButtons) {
	deleteButton.onclick = function () {
		return confirm('Are you sure you want to delete the user?');
	};
}
