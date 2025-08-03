const express = require('express');
const multer = require('multer');
const fs = require('fs');
const path = require('path');
const cors = require('cors');

const app = express();
const PORT = process.env.PORT || 3001;

app.use(cors());
app.use(express.json());
app.use('/media/user-memes', express.static(path.join(__dirname, '../media/user-memes')));

// Ensure user-memes directory exists
const memesDir = path.join(__dirname, '../media/user-memes');
if (!fs.existsSync(memesDir)) {
  fs.mkdirSync(memesDir, { recursive: true });
}

// Multer setup
const storage = multer.diskStorage({
  destination: function (req, file, cb) {
    cb(null, memesDir);
  },
  filename: function (req, file, cb) {
    const unique = Date.now() + '-' + Math.round(Math.random() * 1E9);
    const ext = path.extname(file.originalname);
    cb(null, 'meme-' + unique + ext);
  }
});
const upload = multer({ storage });

// Meme submissions JSON
const memesJsonPath = path.join(memesDir, 'memes.json');
if (!fs.existsSync(memesJsonPath)) {
  fs.writeFileSync(memesJsonPath, '[]');
}

app.post('/api/upload', upload.single('image'), (req, res) => {
  const { caption } = req.body;
  if (!req.file || !caption) {
    return res.status(400).json({ error: 'Image and caption required.' });
  }
  const meme = {
    filename: req.file.filename,
    caption: caption.trim(),
    date: new Date().toISOString()
  };
  // Save to memes.json
  const memes = JSON.parse(fs.readFileSync(memesJsonPath));
  memes.push(meme);
  fs.writeFileSync(memesJsonPath, JSON.stringify(memes, null, 2));
  res.json({ success: true, meme });
});

app.get('/api/memes', (req, res) => {
  const memes = JSON.parse(fs.readFileSync(memesJsonPath));
  res.json(memes);
});

app.listen(PORT, () => {
  console.log(`Meme upload server running on http://localhost:${PORT}`);
});
