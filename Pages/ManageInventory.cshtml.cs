using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Mvc.RazorPages;

namespace Gunventory.Pages;

[Authorize]
public class ManageInventoryModel : PageModel
{
    public void OnGet()
    {
    }
}
