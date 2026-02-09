using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Gunventory.Data;
using Microsoft.AspNetCore.Authorization;

namespace Gunventory.Pages;

[Authorize]
public class DeleteAccessoryModel : PageModel
{
    private readonly GunventoryContext _context;

    public DeleteAccessoryModel(GunventoryContext context)
    {
        _context = context;
    }

    public async Task<IActionResult> OnGetAsync(int? id)
    {
        if (id == null)
        {
            return NotFound();
        }

        var accessory = await _context.Accessories.FindAsync(id);

        if (accessory != null)
        {
            accessory.Status = "I";
            await _context.SaveChangesAsync();
        }

        return Redirect(Request.Headers["Referer"].ToString() ?? "/Index");
    }
}
