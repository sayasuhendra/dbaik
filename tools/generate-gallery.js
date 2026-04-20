const fs = require('fs');
const path = require('path');

const PRODUCTS_DIR = path.join(__dirname, '../img/products');
const OUTPUT_FILE = path.join(__dirname, '../js/gallery-data.js');

function generateGalleryManifest() {
    console.log('--- Generating Gallery Manifest ---');
    
    if (!fs.existsSync(PRODUCTS_DIR)) {
        console.error('Error: Products directory not found:', PRODUCTS_DIR);
        return;
    }

    const categories = fs.readdirSync(PRODUCTS_DIR).filter(file => {
        return fs.statSync(path.join(PRODUCTS_DIR, file)).isDirectory();
    });

    const manifest = {};

    categories.forEach(cat => {
        const catPath = path.join(PRODUCTS_DIR, cat);
        const images = fs.readdirSync(catPath).filter(file => {
            return /\.(png|jpe?g|webp|gif|svg)$/i.test(file);
        });
        
        // Use the relative path from the project root for the frontend
        manifest[cat] = {
            name: cat.replace(/_/g, ' '),
            slug: cat,
            images: images.map(img => `img/products/${cat}/${img}`),
            thumbnail: images.length > 0 ? `img/products/${cat}/${images[0]}` : null
        };
        
        console.log(`- Found category: ${cat} (${images.length} images)`);
    });

    const content = `// Generated automatically by tools/generate-gallery.js
const PRODUCT_GALLERY_DATA = ${JSON.stringify(manifest, null, 2)};`;

    fs.writeFileSync(OUTPUT_FILE, content);
    console.log('--- Manifest generated successfully at js/gallery-data.js ---');
}

generateGalleryManifest();
