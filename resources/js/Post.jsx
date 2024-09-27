import { useState, useEffect } from 'react';
import { useParams } from 'react-router-dom';

function Post() {
    const { id } = useParams();
    const [post, setPost] = useState(null);

    useEffect(() => {
        fetch(`/api/posts/${id}`)
            .then(response => response.json())
            .then(data => setPost(data))
            .catch(error => console.error('Error fetching post:', error));
    }, [id]);

    if (!post) {
        return <p>Loading...</p>;
    }

    return (
        <div>
            <h1>{post.title}</h1>
            <img src={post.image} alt={post.title} style={{ width: '100%', height: 'auto' }} />
            <div dangerouslySetInnerHTML={{ __html: post.content }}></div>
        </div>
    );
}

export default Post;
