const express = require('express');
const path = require('path');

const app = express();
const port = process.env.PORT || 8080;

// Serve static files from public directory
app.use(express.static(path.join(__dirname, 'public')));

// Serve Next.js banking app
app.use('/internet-banking', express.static(path.join(__dirname, 'banking')));

// Banking app SPA routes
app.get('/internet-banking/*', (req, res) => {
    res.sendFile(path.join(__dirname, 'banking/index.html'));
});

// Landing page route
app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, 'public/index.html'));
});

// About page
app.get('/about', (req, res) => {
    res.sendFile(path.join(__dirname, 'public/about.html'));
});

// Services page
app.get('/services', (req, res) => {
    res.sendFile(path.join(__dirname, 'public/services.html'));
});

// Contact page
app.get('/contact', (req, res) => {
    res.sendFile(path.join(__dirname, 'public/contact.html'));
});

// Health check
app.get('/health', (req, res) => {
    res.json({ status: 'healthy', timestamp: new Date().toISOString() });
});

app.listen(port, () => {
    console.log(`Horizon Bank website running on port ${port}`);
});