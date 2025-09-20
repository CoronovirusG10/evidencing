const escapePdfText = (value: string) => {
  return value.replace(/\\/g, '\\\\').replace(/\(/g, '\\(').replace(/\)/g, '\\)');
};

class PdfBuilder {
  private objects: string[] = [''];

  reserve() {
    this.objects.push('');
    return this.objects.length - 1;
  }

  add(body: string) {
    this.objects.push(body);
    return this.objects.length - 1;
  }

  set(id: number, body: string) {
    this.objects[id] = body;
  }

  build(rootId: number) {
    const header = '%PDF-1.4\n';
    const chunks: string[] = [header];
    const offsets: number[] = [0];
    let offset = Buffer.byteLength(header, 'utf8');

    for (let i = 1; i < this.objects.length; i += 1) {
      offsets[i] = offset;
      const body = `${i} 0 obj\n${this.objects[i]}\nendobj\n`;
      chunks.push(body);
      offset += Buffer.byteLength(body, 'utf8');
    }

    const xrefOffset = offset;
    const totalObjects = this.objects.length - 1;
    const xrefEntries = ['xref', `0 ${totalObjects + 1}`, '0000000000 65535 f '];

    for (let i = 1; i <= totalObjects; i += 1) {
      xrefEntries.push(`${offsets[i].toString().padStart(10, '0')} 00000 n `);
    }

    const xref = `${xrefEntries.join('\n')}\n`;
    const trailer = `trailer\n<< /Size ${totalObjects + 1} /Root ${rootId} 0 R >>\nstartxref\n${xrefOffset}\n%%EOF`;

    chunks.push(xref, trailer);

    return Buffer.from(chunks.join(''));
  }
}

const createPageStream = (lines: string[]) => {
  const top = 800;
  const lineHeight = 16;
  let stream = 'BT\n/F1 12 Tf\n';

  lines.forEach((line, index) => {
    const y = top - index * lineHeight;
    stream += `1 0 0 1 50 ${y} Tm (${escapePdfText(line)}) Tj\n`;
  });

  stream += 'ET';
  return stream;
};

const chunkLines = (lines: string[], chunkSize: number) => {
  const chunks: string[][] = [];
  for (let i = 0; i < lines.length; i += chunkSize) {
    chunks.push(lines.slice(i, i + chunkSize));
  }
  return chunks;
};

export type StatementPdfOptions = {
  lines: string[];
};

export const generateStatementPdf = ({ lines }: StatementPdfOptions) => {
  const builder = new PdfBuilder();
  const catalogId = builder.reserve();
  const pagesId = builder.reserve();
  const fontId = builder.add('<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>');

  const lineChunks = chunkLines(lines.length ? lines : ['No transactions for this statement period.'], 44);

  const pageIds: number[] = [];
  const contentIds: number[] = [];

  lineChunks.forEach((chunk) => {
    const stream = createPageStream(chunk);
    const streamBody = `<< /Length ${Buffer.byteLength(stream, 'utf8')} >>\nstream\n${stream}\nendstream`;
    const contentId = builder.add(streamBody);
    const pageId = builder.reserve();
    pageIds.push(pageId);
    contentIds.push(contentId);
  });

  pageIds.forEach((pageId, index) => {
    const contentId = contentIds[index];
    const pageBody = [
      '<<',
      '/Type /Page',
      `/Parent ${pagesId} 0 R`,
      '/MediaBox [0 0 595 842]',
      `/Resources << /Font << /F1 ${fontId} 0 R >> >>`,
      `/Contents ${contentId} 0 R`,
      '>>',
    ].join(' ');

    builder.set(pageId, pageBody);
  });

  const kids = pageIds.map((id) => `${id} 0 R`).join(' ');
  builder.set(pagesId, `<< /Type /Pages /Kids [${kids}] /Count ${pageIds.length} >>`);
  builder.set(catalogId, `<< /Type /Catalog /Pages ${pagesId} 0 R >>`);

  return builder.build(catalogId);
};
