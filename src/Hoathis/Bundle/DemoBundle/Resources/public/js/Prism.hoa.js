Prism.languages.php = {
    'comment':     /\/\*(.|\n)*?(?:\*\/|$)/g,
    'string':      /("|')(\\?.)*?\1/g,
    'icomment':    /\/\/[^\n]*/g,
    'php':         /&lt;\?php/g,
    'variable':    /\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*/g,
    'keyword':     /\b(namespace|class|interface|trait|function|if|else|elseif|return|use|throw|try|catch)\b/g,
    'constant':    /\b(true|false|null)/ig,
    'number':      /[+-]?(0b[01]+|0[0-7]+|0[xX][0-9a-fA-F]+|(0|[1-9]\d*)(\.\d+)?([eE][\+\-]?\d+)?)/g,
    'operator':    /\->|=>|===|!==|==|!=|&amp;|&&|\|\||\b(and|or)\b|(\+|\-|\*|\/|%|\||\^|&lt;|<|&gt;|>|&)=?|=|\.|::/g,
    'punctuation': /[{}\(\)\[\],]/g
};

Prism.languages.shell = {
    'operator': /^\$[^\n]*$/mg,
    'input':    /▋/g
};

Prism.languages.sql = {
    'string':      /("|')(\\?.)*?\1/g,
    'keyword':     /[A-Z]+/g,
    'number':      /[+-]?(0b[01]+|0[0-7]+|0[xX][0-9a-fA-F]+|(0|[1-9]\d*)(\.\d+)?([eE][\+\-]?\d+)?)/g,
    'punctuation': /[\(\),;]/g
};

Prism.languages.pp = {
    'icomment':  /\/\/[^\n]*/g,
    'keyword':   /^%[^\n]+/mg,
    'variable':  /^#?\w+/mg,
    'operator':  /::|:|&lt;|&gt;|\(\)|\(|\)|\||\{|\}|\+|\?|\*/g
};

Prism.languages.json = {
    'string':      /"(\\?.)*?"/g,
    'punctuation': /[\{\}:,]/g
};

Prism.languages.javascript.special_variable = /document|window|this/g
