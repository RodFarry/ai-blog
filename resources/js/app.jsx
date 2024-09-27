import React from 'react';
import ReactDOM from 'react-dom/client';
import { BrowserRouter as Router, Routes, Route, Link } from 'react-router-dom';
import { useState, useEffect } from 'react';
import Post from './Post';
import '../css/styles.scss'; 

function Blog() {
    const [posts, setPosts] = useState([]);
    const [page, setPage] = useState(1);

    useEffect(() => {
        fetch(`/api/posts?page=${page}`)
            .then(response => response.json())
            .then(data => {
                console.log("Fetched posts:", data); // Log the response to check
                setPosts(data.data); // Assuming data is paginated and in `data.data`
            })
            .catch(error => console.error('Error fetching posts:', error));
    }, [page]);

    return (
        <div className='container'>
            <div className='header'>

            </div>
            <div className='content'>    
                <h1>Blog</h1>
                <ul>
                    {posts.map(post => (
                        <li key={post.id}>
                            <h2>
                                <Link to={`/post/${post.id}`}>{post.title}</Link>
                            </h2>
                            <p dangerouslySetInnerHTML={{ __html: post.excerpt }}></p>
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

// Create the root and render the `App` component into the DOM
const root = ReactDOM.createRoot(document.getElementById('app'));
root.render(
    <React.StrictMode>
        <App />
    </React.StrictMode>
);
