/* eslint-disable @typescript-eslint/no-var-requires */
const path = require('path');
require('./register-ts');

try {
  require(path.resolve(__dirname, 'csv.test.ts'));
  require(path.resolve(__dirname, 'pdf.test.ts'));
  console.log('Test suite completed successfully.');
} catch (error) {
  console.error('Test suite failed:', error);
  process.exit(1);
}
