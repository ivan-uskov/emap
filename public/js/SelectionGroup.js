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

            name = "select"+"["+ lastIndex +"]";
            child.name = name;
        }
    }

    $(document).on('click', '#addRowLink', function() {
        let all = $('.empty_row');
        // get last row in page
        let last = all.last();
        // clone this last row
        let newSelectRow = last.clone(true);
        // get children
        let children = newSelectRow.find('input');
        changeRowSelectId(children);
        let selections = $(".inputs");
        selections.append(newSelectRow);
    } );

    $(document).on('click', '.remove_row_link', function() {
        let all = $('.empty_row');
        if(all.length === 1)
        {
            return;
        }

        $(this).parent().remove();
    } );
});