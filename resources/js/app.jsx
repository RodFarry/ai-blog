import { useState, useEffect } from 'react';
import { BrowserRouter as Router, Routes, Route, Link } from 'react-router-dom';
import Post from './Post';

function Blog() {
    const [posts, setPosts] = useState([]);
    const [page, setPage] = useState(1);

    useEffect(() => {
        fetch(`/api/posts?page=${page}`)
            .then(response => response.json())
            .then(data => setPosts(data.data));
    }, [page]);

    return (
        <div>
            <h1>Internal Communications Blog</h1>
            <ul>
                {posts.map(post => (
                    <li key={post.id}>
                        <h2>
                            <Link to={`/post/${post.id}`}>{post.title}</Link>
                        </h2>
                        <p>{post.excerpt}</p>
                        <small>{new Date(post.created_at).toDateString()}</small>
                    </li>
                ))}
            </ul>
            <button onClick={() => setPage(page - 1)} disabled={page === 1}>
                Previous
            </button>
            <button onClick={() => setPage(page + 1)}>
                Next
            </button>
        </div>
    );
}

function App() {
    return (
        <Router>
            <Routes>
                <Route path="/" element={<Blog />} />
                <Route path="/post/:id" element={<Post />} />
            </Routes>
        </Router>
    );
}

export default App;
