// Add this to your JavaScript bundle
function vote(postId, voteType) {
    fetch(`/posts/${postId}/vote`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ vote: voteType })
    })
    .then(response => response.json())
    .then(data => {
        document.querySelector(`#post-${postId}-votes`).textContent = data.votes;
    });
} 