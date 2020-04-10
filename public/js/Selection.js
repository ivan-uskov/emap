$(document).ready(function () {

    function changeRowSelectId(children)
    {
        for(let i = 0; i < children.length; i++)
        {
            let child = children[i];
            let name = child.name;
            let lastIndex = name.match(/[\d+]/)[0];
            // I really hate js
            lastIndex = (+lastIndex + +1);

            let elementId = name.match(/\[\D+\]/);
            name = "select"+"["+ lastIndex +"]"+elementId;
            console.log(name);
            child.name = name;
        }
    }

    $(document).on('click', '#add_row_link', function() {
        let all = $('.empty_row');
        // get last row in page
        let last = all.last();
        // clone this last row
        let newSelectRow = last.clone(true);
        // get children
        let children = newSelectRow.find('input');
        changeRowSelectId(children);
        let selections = $(".selections");
        selections.append(newSelectRow);
    } );

    $(document).on('click', '.remove_row_link', function() {
        let all = $('.empty_row');
        console.log(all.length);
        if(all.length === 1)
        {
            return;
        }

        let th = $(this).parent();
        let td = $(th).parent();
        td.remove();
    } );
});