// Page du JS créée et géré par Thibaut SCheers
// fonction pour la déconnecxion du site
function deco() {
    document.getElementById("deco")
    if (confirm("Voulez vous vous déconnecté?")) {
        window.location.href = "index.php";
    }
}