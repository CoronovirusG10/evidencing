const fs = require('fs');
const ts = require('typescript');

const compilerOptions = {
  module: ts.ModuleKind.CommonJS,
  jsx: ts.JsxEmit.React,
  esModuleInterop: true,
  target: ts.ScriptTarget.ES2019,
  skipLibCheck: true,
};

require.extensions['.ts'] = function register(module, filename) {
  const source = fs.readFileSync(filename, 'utf8');
  const { outputText } = ts.transpileModule(source, {
    compilerOptions,
    fileName: filename,
  });
  module._compile(outputText, filename);
};

require.extensions['.tsx'] = require.extensions['.ts'];
