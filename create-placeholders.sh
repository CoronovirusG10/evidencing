#!/bin/bash

# Create placeholder images for the banking website
echo "🖼️ Creating placeholder images for Horizon Banking Website..."

# Check if ImageMagick is available
if command -v convert &> /dev/null; then
    echo "✅ Using ImageMagick to create placeholder images"

    # Create hero images
    convert -size 1200x600 -background "#1e3a8a" -fill white -pointsize 48 -gravity center -annotate +0+0 "Professional Banking\nHero Image\n1200x600" UI-UX/assets/images/hero-banking.jpg

    convert -size 800x500 -background "#3b82f6" -fill white -pointsize 36 -gravity center -annotate +0+0 "Contact Us\nHero Image\n800x500" UI-UX/assets/images/contact-hero.jpg

    convert -size 900x600 -background "#059669" -fill white -pointsize 36 -gravity center -annotate +0+0 "About Us\nCompany Image\n900x600" UI-UX/assets/images/about-us-hero.jpg

    # Create mobile app mockup
    convert -size 300x600 -background "#f8fafc" -fill "#1e3a8a" -pointsize 24 -gravity center -annotate +0+0 "Mobile Banking\nApp Mockup\n300x600" UI-UX/assets/images/mobile-app-mockup.png

    # Create app store badges
    convert -size 120x40 -background black -fill white -pointsize 12 -gravity center -annotate +0+0 "App Store" UI-UX/assets/images/app-store.png

    convert -size 120x40 -background "#01875f" -fill white -pointsize 12 -gravity center -annotate +0+0 "Google Play" UI-UX/assets/images/google-play.png

    # Create QR code placeholder
    convert -size 150x150 -background white -fill black -pointsize 16 -gravity center -annotate +0+0 "QR Code\nPlaceholder\n150x150" UI-UX/assets/images/qr-code.png

    # Create social sharing image
    convert -size 1200x630 -background "#1e3a8a" -fill white -pointsize 42 -gravity center -annotate +0+0 "Horizon Bank\nProfessional Banking Services\n1200x630" UI-UX/assets/images/og-image.jpg

    echo "✅ Created hero and promotional images"

elif command -v python3 &> /dev/null && python3 -c "from PIL import Image, ImageDraw, ImageFont" &> /dev/null; then
    echo "✅ Using Python PIL to create placeholder images"

    python3 << 'EOF'
from PIL import Image, ImageDraw, ImageFont
import os

def create_placeholder(width, height, text, filename, bg_color="#1e3a8a", text_color="white"):
    image = Image.new('RGB', (width, height), bg_color)
    draw = ImageDraw.Draw(image)

    try:
        # Try to use a system font
        font = ImageFont.truetype("Arial.ttf", 24)
    except:
        font = ImageFont.load_default()

    bbox = draw.textbbox((0, 0), text, font=font)
    text_width = bbox[2] - bbox[0]
    text_height = bbox[3] - bbox[1]

    x = (width - text_width) / 2
    y = (height - text_height) / 2

    draw.text((x, y), text, font=font, fill=text_color)
    image.save(f"UI-UX/assets/images/{filename}")

# Create all placeholder images
create_placeholder(1200, 600, "Professional Banking\nHero Image", "hero-banking.jpg")
create_placeholder(800, 500, "Contact Us\nHero Image", "contact-hero.jpg", "#3b82f6")
create_placeholder(900, 600, "About Us\nCompany Image", "about-us-hero.jpg", "#059669")
create_placeholder(300, 600, "Mobile Banking\nApp Mockup", "mobile-app-mockup.png", "#f8fafc", "#1e3a8a")
create_placeholder(120, 40, "App Store", "app-store.png", "black")
create_placeholder(120, 40, "Google Play", "google-play.png", "#01875f")
create_placeholder(150, 150, "QR Code", "qr-code.png", "white", "black")
create_placeholder(1200, 630, "Horizon Bank\nProfessional Banking", "og-image.jpg")

print("✅ Created all placeholder images with Python PIL")
EOF

else
    echo "⚠️ Neither ImageMagick nor Python PIL available, creating basic placeholder files..."

    # Create empty placeholder files (better than missing files)
    touch UI-UX/assets/images/hero-banking.jpg
    touch UI-UX/assets/images/contact-hero.jpg
    touch UI-UX/assets/images/about-us-hero.jpg
    touch UI-UX/assets/images/mobile-app-mockup.png
    touch UI-UX/assets/images/app-store.png
    touch UI-UX/assets/images/google-play.png
    touch UI-UX/assets/images/qr-code.png
    touch UI-UX/assets/images/og-image.jpg

    echo "⚠️ Created empty placeholder files - images will need to be replaced"
fi

# Create logo placeholders
echo "🏢 Creating logo placeholders..."

mkdir -p UI-UX/assets/images/logo

if command -v convert &> /dev/null; then
    # Create logo with ImageMagick
    convert -size 200x60 -background white -fill "#1e3a8a" -pointsize 18 -gravity center -annotate +0+0 "HORIZON BANK" UI-UX/assets/images/logo/main.png

    convert -size 200x60 -background "#1e3a8a" -fill white -pointsize 18 -gravity center -annotate +0+0 "HORIZON BANK" UI-UX/assets/images/logo/white.png

    # Create a simple favicon
    convert -size 32x32 -background "#1e3a8a" -fill white -pointsize 16 -gravity center -annotate +0+0 "H" UI-UX/assets/images/logo/favicon.ico

elif command -v python3 &> /dev/null && python3 -c "from PIL import Image, ImageDraw, ImageFont" &> /dev/null; then
    # Create logo with Python
    python3 << 'EOF'
from PIL import Image, ImageDraw, ImageFont

# Main logo (dark text on white)
logo = Image.new('RGB', (200, 60), 'white')
draw = ImageDraw.Draw(logo)
try:
    font = ImageFont.truetype("Arial.ttf", 18)
except:
    font = ImageFont.load_default()

text = "HORIZON BANK"
bbox = draw.textbbox((0, 0), text, font=font)
text_width = bbox[2] - bbox[0]
x = (200 - text_width) / 2
y = 20

draw.text((x, y), text, font=font, fill="#1e3a8a")
logo.save("UI-UX/assets/images/logo/main.png")

# White logo (white text on dark)
logo_white = Image.new('RGB', (200, 60), '#1e3a8a')
draw_white = ImageDraw.Draw(logo_white)
draw_white.text((x, y), text, font=font, fill="white")
logo_white.save("UI-UX/assets/images/logo/white.png")

# Favicon
favicon = Image.new('RGB', (32, 32), '#1e3a8a')
draw_favicon = ImageDraw.Draw(favicon)
draw_favicon.text((10, 8), "H", font=font, fill="white")
favicon.save("UI-UX/assets/images/logo/favicon.ico")

print("✅ Created logo files")
EOF

else
    touch UI-UX/assets/images/logo/main.png
    touch UI-UX/assets/images/logo/white.png
    touch UI-UX/assets/images/logo/favicon.ico
fi

echo ""
echo "✅ Placeholder creation completed!"
echo ""
echo "📁 Created files:"
echo "   🖼️ Hero images: hero-banking.jpg, contact-hero.jpg, about-us-hero.jpg"
echo "   📱 Mobile mockup: mobile-app-mockup.png"
echo "   📲 App badges: app-store.png, google-play.png"
echo "   🔗 QR code: qr-code.png"
echo "   🌐 Social image: og-image.jpg"
echo "   🏢 Logos: main.png, white.png, favicon.ico"
echo ""
echo "🚀 Your homepage is now ready for deployment!"
echo "   Run: ./deploy-integrated.sh"