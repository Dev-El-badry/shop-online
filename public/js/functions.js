function convertToSlug(Text)
{
    return Text
        .toLowerCase()
        .replace(/ /g,'-')
        .replace(/[^\w-]+/g,'')
        ;
}

function make_slug(str)
{
	return str.replace(/\s+/g, '-').toLowerCase();
}