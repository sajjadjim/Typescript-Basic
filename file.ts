import { readFileSync, writeFileSync } from 'fs';
import { Document, Packer, Paragraph, TextRun } from 'docx';
import PDFDocument from 'pdfkit';

// Function to convert DOCX to PDF
async function docxToPdf(docxPath: string, pdfPath: string) {
    // Read DOCX file
    const docxBuffer = readFileSync(docxPath);

    // Parse DOCX (basic text extraction)
    // For full-featured conversion, use a library like mammoth
    const doc = await Document.load(docxBuffer);
    const paragraphs = doc.getSections().flatMap(section =>
        section.properties.children.filter(child => child instanceof Paragraph)
    );

    // Create PDF
    const pdfDoc = new PDFDocument();
    pdfDoc.pipe(writeFileSync(pdfPath));

    paragraphs.forEach(paragraph => {
        const text = paragraph.children
            .filter(child => child instanceof TextRun)
            .map((run: TextRun) => run.text)
            .join('');
        pdfDoc.text(text);
        pdfDoc.moveDown();
    });

    pdfDoc.end();
}

// Usage
const docxPath = 'input.docx';
const pdfPath = 'output.pdf';

docxToPdf(docxPath, pdfPath)
    .then(() => console.log('Conversion complete!'))
    .catch(err => console.error('Error:', err));