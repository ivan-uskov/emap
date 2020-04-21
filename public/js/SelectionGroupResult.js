$(() => {
    const data = $('#commonGraphData').data('data');

    let datasets = [];
    data.items.forEach((selection) => {
        let color = Color.get();
        selection.values.forEach((item) => datasets.push(createDataset(item.uid, item.notes, color)));
    });
    new Chart(document.getElementById('commonContainerCanvas'), {
        type: 'line',
        data: {labels: [...Array(data.length).keys()], datasets: datasets},
        options: createOptions(data.yAxis)
    });

    $('#saveBtn').click(() => {
        $('#saveSelectionForm').submit();
        return false;
    });
});