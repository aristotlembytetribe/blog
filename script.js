function createPost() {
    const title = document.getElementById('title').value;
    const content = document.getElementById('content').value;

    if (title && content) {
        fetch('blog.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=create&title=${encodeURIComponent(title)}&content=${encodeURIComponent(content)}`
        }).then(() => location.reload());
    } else {
        alert('Title and content are required.');
    }
}

// function updatePost(id) {
//     const post = document.querySelector(`.card[data-id='${id}']`);
//     const title = post.querySelector('.card-title').innerText;
//     const content = post.querySelector('.card-text').innerText;

//     fetch('blog.php', {
//         method: 'POST',
//         headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
//         body: `action=update&id=${id}&title=${encodeURIComponent(title)}&content=${encodeURIComponent(content)}`
//     }).then(() => alert('Post updated!'));
// }

function deletePost(id) {
    if (confirm('Are you sure you want to delete this post?')) {
        fetch('blog.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=delete&id=${id}`
        }).then(() => location.reload());
    }
}
